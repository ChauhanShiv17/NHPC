<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password'));

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)
                          ->where('password', $password)
                          ->first();

        if ($user) {
            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true
            ]);

            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($user['role'] === 'author') {
                return redirect()->to('/author/dashboard');
            } else {
                return redirect()->to('/');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid login details');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function doRegister()
{
    $userModel = new \App\Models\UserModel();

    $data = [
        'username'   => $this->request->getPost('username'),
        'email'      => $this->request->getPost('email'), // ✅ New
        'password'   => md5($this->request->getPost('password')),
        'role'       => $this->request->getPost('role'),
        'created_at' => date('Y-m-d H:i:s')
    ];

    $userModel->insert($data);

    return redirect()->to('/login')->with('success', 'Registration successful. You can now login.');
}


    public function logout()
{
    session()->destroy();
    return redirect()->to('/login')->with('message', 'You have been logged out successfully.');
}

}
