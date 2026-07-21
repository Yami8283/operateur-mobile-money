<?php

namespace App\Controllers;

use App\Models\OperatorModel;
use App\Models\PrefixModel;
use App\Models\OperationTypeModel;
use App\Models\FeeBandModel;
use CodeIgniter\Controller;

class Operateur extends Controller
{
    // =============================================
    // PRÉFIXES
    // =============================================

    public function prefixes()
    {
        $operatorModel = new OperatorModel();
        $operators = $operatorModel->getAllWithPrefixes();

        $data = [
            'operators' => $operators
        ];

        return view('operateur/prefixes', $data);
    }

    public function ajouterPrefixeForm()
    {
        return view('operateur/ajouter_prefixe');
    }

    public function ajouterPrefixe()
    {
        $rules = [
            'operator_id' => 'required|integer',
            'prefix'      => 'required|min_length[3]|max_length[10]|is_unique[prefixes.prefix]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $prefixModel = new PrefixModel();
        $prefixModel->insert([
            'operator_id' => $this->request->getPost('operator_id'),
            'prefix'      => $this->request->getPost('prefix')
        ]);

        return redirect()->to('operateur/prefixes')->with('success', 'Préfixe ajouté avec succès.');
    }

    // =============================================
    // OPÉRATIONS ET BARÈMES
    // =============================================

    public function operations()
    {
        $feeBandModel = new FeeBandModel();
        $feeBands = $feeBandModel->getWithOperationType();

        $grouped = [];
        foreach ($feeBands as $band) {
            $grouped[$band['operation_name']][] = $band;
        }

        $data = [
            'groupedBands' => $grouped
        ];

        return view('operateur/operations', $data);
    }

    public function ajouterBaremeForm()
    {
        $operationTypeModel = new OperationTypeModel();
        $data['operationTypes'] = $operationTypeModel->findAll();

        return view('operateur/ajouter_bareme', $data);
    }

    public function ajouterBareme()
    {
        $rules = [
            'operation_type_id' => 'required',
            'min_amount'        => 'required',
            'max_amount'        => 'required',
            'fee_flat'          => 'permit_empty',
            'fee_percent'       => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $feeBandModel = new FeeBandModel();
        $feeBandModel->insert([
            'operation_type_id' => (int) $this->request->getPost('operation_type_id'),
            'min_amount'        => (int) $this->request->getPost('min_amount'),
            'max_amount'        => (int) $this->request->getPost('max_amount'),
            'fee_flat'          => (int) ($this->request->getPost('fee_flat') ?? 0),
            'fee_percent'       => (float) ($this->request->getPost('fee_percent') ?? 0),
        ]);

        return redirect()->to('operateur/operations')->with('success', 'Barème ajouté avec succès.');
    }

    // =============================================
    // CLIENTS
    // =============================================

    public function clients()
    {
        $clientModel = new \App\Models\ClientModel();
        $data['clients'] = $clientModel->getWithBalance();

        return view('operateur/clients', $data);
    }

    // =============================================
    // GAINS
    // =============================================

    public function gains()
    {
        $db = \Config\Database::connect();
        
        $queryLocal = $db->table('transactions')
            ->select('operation_types.name as operation_name, SUM(transactions.fee) as total_frais, COUNT(transactions.id) as nombre')
            ->join('operation_types', 'operation_types.id = transactions.operation_type_id')
            ->join('clients cf', 'cf.id = transactions.client_from', 'left')
            ->join('clients ct', 'ct.id = transactions.client_to', 'left')
            ->join('prefixes p_from', 'p_from.prefix = substr(cf.phone, 1, 3)', 'left')
            ->join('prefixes p_to', 'p_to.prefix = substr(ct.phone, 1, 3)', 'left')
            ->groupStart()
                ->where('p_from.operator_id', 1)
                ->orWhere('p_to.operator_id', 1)
            ->groupEnd()
            ->groupBy('transactions.operation_type_id')
            ->get();

        $queryAutres = $db->table('transactions')
            ->select('operation_types.name as operation_name, SUM(transactions.fee) as total_frais, COUNT(transactions.id) as nombre')
            ->join('operation_types', 'operation_types.id = transactions.operation_type_id')
            ->join('clients cf', 'cf.id = transactions.client_from', 'left')
            ->join('clients ct', 'ct.id = transactions.client_to', 'left')
            ->join('prefixes p_from', 'p_from.prefix = substr(cf.phone, 1, 3)', 'left')
            ->join('prefixes p_to', 'p_to.prefix = substr(ct.phone, 1, 3)', 'left')
            ->groupStart()
                ->where('p_from.operator_id !=', 1)
                ->where('p_from.operator_id IS NOT NULL')
            ->groupEnd()
            ->orGroupStart()
                ->where('p_to.operator_id !=', 1)
                ->where('p_to.operator_id IS NOT NULL')
            ->groupEnd()
            ->groupBy('transactions.operation_type_id')
            ->get();

        $gainsLocal = $queryLocal->getResultArray();
        $gainsAutres = $queryAutres->getResultArray();
        $totalLocal = array_sum(array_column($gainsLocal, 'total_frais'));
        $totalAutres = array_sum(array_column($gainsAutres, 'total_frais'));

        $data = [
            'gainsLocal'  => $gainsLocal,
            'gainsAutres' => $gainsAutres,
            'totalLocal'  => $totalLocal,
            'totalAutres' => $totalAutres
        ];

        return view('operateur/gains', $data);
    }

    // =============================================
    // COMMISSIONS
    // =============================================

    public function commissions()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('transactions')
            ->select('operators.name as operateur_name, 
                      SUM(transactions.amount) as total_transfere,
                      COUNT(transactions.id) as nombre,
                      oc.commission_percent')
            ->join('clients ct', 'ct.id = transactions.client_to')
            ->join('prefixes p', 'p.prefix = substr(ct.phone, 1, 3)')
            ->join('operators', 'operators.id = p.operator_id')
            ->join('operator_commissions oc', 'oc.to_operator_id = operators.id', 'left')
            ->where('transactions.operation_type_id', 3)
            ->where('p.operator_id !=', 1)
            ->groupBy('p.operator_id')
            ->get();

        $data['commissions'] = $query->getResultArray();

        return view('operateur/commissions', $data);
    }

        public function configIntraFee()
    {
        $db = \Config\Database::connect();
        $data['operators'] = $db->table('operators')->get()->getResultArray();
        return view('operateur/config_intra_fee', $data);
    }

    public function updateIntraFee()
    {
        $id = $this->request->getPost('operator_id');
        $percent = $this->request->getPost('intra_fee_percent');
        $db = \Config\Database::connect();
        $db->table('operators')->where('id', $id)->update(['intra_fee_percent' => $percent]);
        return redirect()->to('operateur/config-intra-fee')->with('success', 'Pourcentage mis à jour.');
    }
        public function configEpargne()
    {
        $db = \Config\Database::connect();
        $data['operators'] = $db->table('operators')->get()->getResultArray();
        return view('operateur/config_epargne', $data);
    }

    public function updateEpargneRate()
    {
        $id = $this->request->getPost('operator_id');
        $rate = $this->request->getPost('savings_rate');
        $db = \Config\Database::connect();
        $db->table('operators')->where('id', $id)->update(['savings_rate' => $rate]);
        return redirect()->to('operateur/config-epargne')->with('success', 'Taux mis à jour.');
    }
}