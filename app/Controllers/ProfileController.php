<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $this->requireLogin();

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('user_id'));

        return view('profile/index', ['user' => $user]);
    }
}
