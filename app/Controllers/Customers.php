<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    /**
     * Customer Accounts page ("/customers")
     * Records are retrieved from the `customers` table through CustomerModel.
     */
    public function index()
    {
        $customerModel = new CustomerModel();

        $data = [
            'title'     => 'Customer Accounts',
            'customers' => $customerModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('templates/header', $data)
            . view('customers/index', $data)
            . view('templates/footer');
    }
}
