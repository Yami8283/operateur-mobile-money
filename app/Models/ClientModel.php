<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table      = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['phone', 'name'];

    /**
     * Récupère tous les clients avec leur solde
     */
    public function getWithBalance()
    {
        return $this->select('clients.*, accounts.balance')
                    ->join('accounts', 'accounts.client_id = clients.id', 'left')
                    ->findAll();
    }
}