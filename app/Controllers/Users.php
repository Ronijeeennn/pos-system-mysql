<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    /**
     * User Accounts page ("/users")
     * Records are retrieved from the `users` table through UserModel.
     */
    public function index()
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'User Accounts',
            'users' => $userModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('templates/header', $data)
            . view('users/index', $data)
            . view('templates/footer');
    }
}
