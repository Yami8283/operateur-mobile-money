<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table      = 'prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operator_id', 'prefix'];
}