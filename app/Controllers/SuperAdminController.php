<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemTransactionModel;
use App\Models\TransactionModel;
use App\Models\UserModel;

class SuperAdminController extends BaseController
{
    protected $userModel;
    protected $transactionModel;
    protected $itemTransactionModel;

    public function __construct()
    {
        if (session()->get('role') != "super_admin") {
            echo 'Access denied';
            exit;
        }

        $this->userModel = new UserModel();
        $this->transactionModel = new TransactionModel();
        $this->itemTransactionModel = new ItemTransactionModel();
    }

    public function index()
    {
        $userCount = $this->userModel->getCountUser();
        $adminCount = $this->userModel->getCountAdmin();
        $transactionCount = $this->transactionModel->getCountTransaction();
        $totalTransaction = $this->itemTransactionModel->getTrasaction();

        $incomeTransaction = 0;
        foreach ($totalTransaction as $d) {
            $totalItemTrasaction[] = $d['total'];
            $incomeTransaction = array_sum($totalItemTrasaction);
        }

        $data = [
            'userCount' => $userCount,
            'adminCount' => $adminCount,
            'incomeTransaction' => $incomeTransaction,
            'transactionCount' => $transactionCount,
        ];

        return view("super_admin/dashboard", $data);
    }
}
