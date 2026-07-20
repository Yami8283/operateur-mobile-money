<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_from', 'client_to', 'operation_type_id', 'amount', 'fee', 'reference'];

    /**
     * Récupère l'historique d'un client
     */
    public function getByClient(int $clientId)
    {
        return $this->select('transactions.*, ot.name as operation_name')
                    ->join('operation_types ot', 'ot.id = transactions.operation_type_id')
                    ->groupStart()
                        ->where('client_from', $clientId)
                        ->orWhere('client_to', $clientId)
                    ->groupEnd()
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}