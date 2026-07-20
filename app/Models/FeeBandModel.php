<?php

namespace App\Models;

use CodeIgniter\Model;

class FeeBandModel extends Model
{
    protected $table      = 'fee_bands';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operation_type_id', 'min_amount', 'max_amount', 'fee_flat', 'fee_percent'];

    public function getWithOperationType()
    {
        return $this->select('fee_bands.*, operation_types.name as operation_name, operation_types.code as operation_code')
                    ->join('operation_types', 'operation_types.id = fee_bands.operation_type_id')
                    ->findAll();
    }

    public function getByOperationType(int $operationTypeId)
    {
        return $this->where('operation_type_id', $operationTypeId)
                    ->orderBy('min_amount', 'ASC')
                    ->findAll();
    }
}