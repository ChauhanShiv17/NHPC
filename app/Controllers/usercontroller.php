<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function profile()
    {
        $this->requireLogin();

        $userModel = new UserModel();
        $userId = session()->get('user_id');

        $data['user'] = $userModel->find($userId);

        return view('user/profile', $data);
    }
}
