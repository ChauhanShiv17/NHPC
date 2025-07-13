<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Show login page
    public function login()
    {
        return view('auth/login');
    }

    // Handle login form submission
    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password'));

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)
                          ->where('password', $password)
                          ->first();

        if ($user) {
            // ✅ Blocked users: is_approved = -1
            if ($user['is_approved'] == -1) {
                return redirect()->back()->with('error', 'You have been blocked by admin.');
            }

            // ✅ Pending admins: is_approved = 0
            if ($user['role'] === 'admin' && $user['is_approved'] != 1) {
                return redirect()->back()->with('error', 'Your admin account is pending approval by another admin.');
            }

            // ✅ Allow only approved users (is_approved = 1)
            if ($user['is_approved'] == 1) {
                // Set session
                session()->set([
                    'user_id'    => $user['id'],
                    'username'   => $user['username'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true
                ]);

                // Redirect by role
                if ($user['role'] === 'admin') {
                    return redirect()->to('/home');

                } else {
                    return redirect()->to('/'); // authors & viewers go to homepage first
                }
            }

            // fallback: user exists but not approved
            return redirect()->back()->with('error', 'Your account is not approved yet.');
        }

        // Invalid login
        return redirect()->back()->with('error', 'Invalid login details');
    }

    // Show register page
    public function register()
    {
        return view('auth/register');
    }

    // Handle register form submission
    public function doRegister()
    {
        $userModel = new UserModel();

        $data = [
            'username'    => $this->request->getPost('username'),
            'email'       => $this->request->getPost('email'),
            'password'    => md5($this->request->getPost('password')),
            'role'        => $this->request->getPost('role'),
            'created_at'  => date('Y-m-d H:i:s'),
            'is_approved' => ($this->request->getPost('role') == 'admin') ? 0 : 1 // admin needs approval, others auto approved
        ];

        $userModel->insert($data);

        return redirect()->to('/login')->with('success', 'Registration successful. You can now login.');
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'You have been logged out successfully.');
    }
}
