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
        
        $fee = $this->calculateFee(2, $amount);
        $total = $amount + $fee;

        $db = \Config\Database::connect();
        
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
            'amount'            => $amount,
            'fee'               => $fee,
            'reference'         => 'WDR-' . date('YmdHis') . '-' . $client['id']
        ]);

        $db->transComplete();

        return redirect()->to('client/compte')->with('success', 'Retrait de ' . number_format($amount / 100, 2) . ' Ar. Frais : ' . number_format($fee / 100, 2) . ' Ar');
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
}