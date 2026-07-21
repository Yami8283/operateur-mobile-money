<?php

namespace App\Controllers;

use App\Models\ClientModel;
use CodeIgniter\Controller;

class Client extends Controller
{
    /**
     * Page d'accueil client : formulaire de login
     */
    public function login()
    {
        return view('client/login');
    }

    /**
     * Traitement du login automatique (GET)
     */
    public function doLogin()
    {
        $phone = $this->request->getGet('phone');
        
        if (empty($phone)) {
            return redirect()->to('client/login')->with('error', 'Numéro requis');
        }

        $clientModel = new ClientModel();
        $client = $clientModel->where('phone', $phone)->first();

        if (!$client) {
            $clientModel->insert(['phone' => $phone]);
            $client = $clientModel->where('phone', $phone)->first();
            
            $db = \Config\Database::connect();
            $db->table('accounts')->insert([
                'client_id' => $client['id'],
                'balance'   => 0
            ]);
        }

        session()->set('client', $client);
        return redirect()->to('client/compte');
    }

    /**
     * Page compte client (solde et opérations)
     */
    public function compte()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }

        $db = \Config\Database::connect();
        $account = $db->table('accounts')->where('client_id', $client['id'])->get()->getRowArray();

        $data = [
            'client'  => $client,
            'balance' => $account['balance'] ?? 0
        ];

        return view('client/compte', $data);
    }

    /**
     * Déconnexion
     */
    public function logout()
    {
        session()->remove('client');
        return redirect()->to('client/login');
    }

    /**
     * Formulaire de dépôt
     */
    public function depot()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }
        return view('client/depot');
    }

    /**
     * Traitement du dépôt (GET)
     */
    public function doDepot()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }

        $amount = (int) $this->request->getGet('amount');
        
        if ($amount <= 0) {
            return redirect()->to('client/depot')->with('error', 'Montant invalide');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $db->table('accounts')
           ->where('client_id', $client['id'])
           ->set('balance', 'balance + ' . $amount, false)
           ->update();

        $db->table('transactions')->insert([
            'client_to'         => $client['id'],
            'operation_type_id' => 1,
            'amount'            => $amount,
            'fee'               => 0,
            'reference'         => 'DEP-' . date('YmdHis') . '-' . $client['id']
        ]);

        $db->transComplete();

        return redirect()->to('client/compte')->with('success', 'Dépôt de ' . number_format($amount / 100, 2) . ' Ar effectué');
    }

    /**
     * Formulaire de retrait
     */
    public function retrait()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }
        return view('client/retrait');
    }

    /**
     * Traitement du retrait (GET)
     */
        public function doRetrait()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }

        $amount = (int) $this->request->getGet('amount');
        $fraisInclus = $this->request->getGet('frais_inclus') == '1';
        
        // Vérifier si c'est un autre opérateur (pas de frais)
        $prefix = substr($client['phone'], 0, 3);
        $db = \Config\Database::connect();
        $prefixData = $db->table('prefixes')->where('prefix', $prefix)->get()->getRowArray();
        $isOperateurLocal = $prefixData && $prefixData['operator_id'] == 1;

        // Calculer les frais seulement pour l'opérateur local
        $fee = $isOperateurLocal ? $this->calculateFee(2, $amount) : 0;

        if ($fraisInclus && $fee > 0) {
            // Le montant saisi inclut les frais
            $total = $amount;
            $amountReel = $amount - $fee;
        } else {
            $total = $amount + $fee;
            $amountReel = $amount;
        }

        $account = $db->table('accounts')->where('client_id', $client['id'])->get()->getRowArray();
        if (!$account || $account['balance'] < $total) {
            return redirect()->to('client/retrait')->with('error', 'Solde insuffisant');
        }

        $db->transStart();

        $db->table('accounts')
           ->where('client_id', $client['id'])
           ->set('balance', 'balance - ' . $total, false)
           ->update();

        $db->table('transactions')->insert([
            'client_from'       => $client['id'],
            'operation_type_id' => 2,
            'amount'            => $amountReel,
            'fee'               => $fee,
            'reference'         => 'WDR-' . date('YmdHis') . '-' . $client['id']
        ]);

        $db->transComplete();

        $msg = 'Retrait de ' . number_format($amountReel / 100, 2) . ' Ar';
        if ($fee > 0) {
            $msg .= '. Frais : ' . number_format($fee / 100, 2) . ' Ar';
        }

        return redirect()->to('client/compte')->with('success', $msg);
    }

    /**
     * Calculer les frais selon le barème
     */
    private function calculateFee(int $operationTypeId, int $amount): int
    {
        $db = \Config\Database::connect();
        $band = $db->table('fee_bands')
                   ->where('operation_type_id', $operationTypeId)
                   ->where('min_amount <=', $amount)
                   ->where('max_amount >=', $amount)
                   ->get()
                   ->getRowArray();

        if (!$band) {
            return 0;
        }

        $fee = (int) $band['fee_flat'];
        if ($band['fee_percent'] > 0) {
            $fee += (int) round($amount * $band['fee_percent'] / 100);
        }

        return $fee;
    }

        /**
     * Formulaire de transfert
     */
    public function transfert()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }
        return view('client/transfert');
    }

    /**
     * Traitement du transfert (GET)
     */
           public function doTransfert()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }

        $destinatairesBruts = $this->request->getGet('destinataires');
        $amountTotal = (int) $this->request->getGet('amount');
        
        $destinataires = array_filter(array_map('trim', explode("\n", $destinatairesBruts)));
        
        if (empty($destinataires) || $amountTotal <= 0) {
            return redirect()->to('client/transfert')->with('error', 'Données invalides');
        }

        $db = \Config\Database::connect();
        $prefixClient = substr($client['phone'], 0, 3);
        $prefixData = $db->table('prefixes')->where('prefix', $prefixClient)->get()->getRowArray();
        $operateurClient = $prefixData['operator_id'] ?? 0;

        $clientModel = new ClientModel();
        $dests = [];
        
        foreach ($destinataires as $num) {
            if ($num === $client['phone']) {
                return redirect()->to('client/transfert')->with('error', 'Vous ne pouvez pas vous envoyer à vous-même');
            }
            
            $dest = $clientModel->where('phone', $num)->first();
            if (!$dest) {
                return redirect()->to('client/transfert')->with('error', 'Numéro ' . $num . ' introuvable');
            }
            $dests[] = $dest;
        }

        // Si envoi multiple, vérifier même opérateur
        if (count($dests) > 1) {
            foreach ($dests as $dest) {
                $prefixDest = substr($dest['phone'], 0, 3);
                $prefixDestData = $db->table('prefixes')->where('prefix', $prefixDest)->get()->getRowArray();
                if (!$prefixDestData || $prefixDestData['operator_id'] != $operateurClient) {
                    return redirect()->to('client/transfert')->with('error', 'Envoi multiple : tous les destinataires doivent être du même opérateur');
                }
            }
        }

        $nbDests = count($dests);
        $amountParDest = intdiv($amountTotal, $nbDests);

        $feeUnitaire = $this->calculateFee(3, $amountParDest);
        $feeTotal = $feeUnitaire * $nbDests;
        $totalADebiter = $amountTotal + $feeTotal;

        $account = $db->table('accounts')->where('client_id', $client['id'])->get()->getRowArray();
        if (!$account || $account['balance'] < $totalADebiter) {
            return redirect()->to('client/transfert')->with('error', 'Solde insuffisant');
        }

        $db->transStart();

        $db->table('accounts')
           ->where('client_id', $client['id'])
           ->set('balance', 'balance - ' . $totalADebiter, false)
           ->update();

        $reference = 'TRF-' . date('YmdHis') . '-' . $client['id'];
        foreach ($dests as $dest) {
            $db->table('accounts')
               ->where('client_id', $dest['id'])
               ->set('balance', 'balance + ' . $amountParDest, false)
               ->update();

            $db->table('transactions')->insert([
                'client_from'       => $client['id'],
                'client_to'         => $dest['id'],
                'operation_type_id' => 3,
                'amount'            => $amountParDest,
                'fee'               => $feeUnitaire,
                'reference'         => $reference
            ]);
        }

        $db->transComplete();

        return redirect()->to('client/compte')->with('success', 'Transfert de ' . number_format($amountParDest / 100, 2) . ' Ar vers ' . $nbDests . ' personne(s). Frais : ' . number_format($feeTotal / 100, 2) . ' Ar');
    }
    /**
     * Historique des transactions
     */
    public function historique()
    {
        $client = session()->get('client');
        if (!$client) {
            return redirect()->to('client/login');
        }

        $db = \Config\Database::connect();
        
        $transactions = $db->table('transactions')
            ->select('transactions.*, 
                      op.name as operation_name,
                      sender.phone as from_phone,
                      receiver.phone as to_phone')
            ->join('operation_types op', 'op.id = transactions.operation_type_id')
            ->join('clients sender', 'sender.id = transactions.client_from', 'left')
            ->join('clients receiver', 'receiver.id = transactions.client_to', 'left')
            ->groupStart()
                ->where('transactions.client_from', $client['id'])
                ->orWhere('transactions.client_to', $client['id'])
            ->groupEnd()
            ->orderBy('transactions.created_at', 'DESC')
            ->limit(50)
            ->get()
            ->getResultArray();

        $data = [
            'client'       => $client,
            'transactions' => $transactions
        ];

        return view('client/historique', $data);
    }
}