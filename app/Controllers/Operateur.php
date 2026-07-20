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

    /**
     * Affiche la liste des préfixes de l'opérateur
     */
    public function prefixes()
    {
        $operatorModel = new OperatorModel();
        $operator = $operatorModel->getWithPrefixes(1);

        if (!$operator) {
            return redirect()->to('/')->with('error', 'Opérateur non trouvé.');
        }

        $data = [
            'operator' => $operator,
            'prefixes' => $operator['prefixes'] ?? []
        ];

        return view('operateur/prefixes', $data);
    }

    /**
     * Formulaire d'ajout d'un préfixe
     */
    public function ajouterPrefixeForm()
    {
        return view('operateur/ajouter_prefixe');
    }

    /**
     * Traitement de l'ajout d'un préfixe
     */
    public function ajouterPrefixe()
    {
        $rules = [
            'prefix' => 'required|min_length[3]|max_length[10]|is_unique[prefixes.prefix]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $prefixModel = new PrefixModel();
        $prefixModel->insert([
            'operator_id' => 1,
            'prefix'      => $this->request->getPost('prefix')
        ]);

        return redirect()->to('operateur/prefixes')->with('success', 'Préfixe ajouté avec succès.');
    }

    // =============================================
    // OPÉRATIONS ET BARÈMES
    // =============================================

    /**
     * Affiche les types d'opérations et leurs barèmes
     */
    public function operations()
    {
        $feeBandModel = new FeeBandModel();
        $feeBands = $feeBandModel->getWithOperationType();

        // Regrouper par type d'opération
        $grouped = [];
        foreach ($feeBands as $band) {
            $grouped[$band['operation_name']][] = $band;
        }

        $data = [
            'groupedBands' => $grouped
        ];

        return view('operateur/operations', $data);
    }

    /**
     * Formulaire pour ajouter un barème de frais
     */
    public function ajouterBaremeForm()
    {
        $operationTypeModel = new OperationTypeModel();
        $data['operationTypes'] = $operationTypeModel->findAll();

        return view('operateur/ajouter_bareme', $data);
    }

    /**
     * Traitement de l'ajout d'un barème
     */
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

        /**
     * Affiche la situation des comptes clients
     */
    public function clients()
    {
        $clientModel = new \App\Models\ClientModel();
        $data['clients'] = $clientModel->getWithBalance();

        return view('operateur/clients', $data);
    }

        /**
     * Affiche la situation des gains (frais perçus)
     */
    public function gains()
    {
        $db = \Config\Database::connect();
        
        // Total des frais par type d'opération
        $query = $db->table('transactions')
                    ->select('operation_types.name as operation_name, SUM(transactions.fee) as total_frais, COUNT(transactions.id) as nombre')
                    ->join('operation_types', 'operation_types.id = transactions.operation_type_id')
                    ->groupBy('transactions.operation_type_id')
                    ->get();

        $data['gains'] = $query->getResultArray();
        $data['total'] = array_sum(array_column($data['gains'], 'total_frais'));

        return view('operateur/gains', $data);
    }
}