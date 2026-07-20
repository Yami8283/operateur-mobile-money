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
}