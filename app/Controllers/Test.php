<?php

namespace App\Controllers;

class Test extends \CodeIgniter\Controller
{
    public function post()
    {
        return $this->response->setJSON([
            'method' => $_SERVER['REQUEST_METHOD'],
            'phone'  => $this->request->getPost('phone')
        ]);
    }
}