<?php

namespace App\Models;

use CodeIgniter\Model;

class OperatorModel extends Model
{
    protected $table      = 'operators';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    /**
     * Récupère un opérateur avec ses préfixes
     */
    public function getWithPrefixes(int $operatorId = 1)
    {
        $operator = $this->find($operatorId);
        if (!$operator) {
            return null;
        }

        $prefixModel = new PrefixModel();
        $operator['prefixes'] = $prefixModel->where('operator_id', $operatorId)->findAll();

        return $operator;
    }

    /**
     * Récupère tous les opérateurs avec leurs préfixes
     */
    public function getAllWithPrefixes()
    {
        $operators = $this->findAll();
        $prefixModel = new PrefixModel();

        foreach ($operators as &$op) {
            $op['prefixes'] = $prefixModel->where('operator_id', $op['id'])->findAll();
        }

        return $operators;
    }
}