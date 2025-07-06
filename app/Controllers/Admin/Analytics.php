<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\UserModel;

class Analytics extends BaseController
{
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $userModel = new UserModel();

        $data['totalBlogs'] = $blogModel->countAll();
        $data['totalAdmins'] = $userModel->where('role', 'admin')->countAllResults();
        $data['totalAuthors'] = $userModel->where('role', 'author')->countAllResults();
        $data['totalViewers'] = $userModel->where('role', 'viewer')->countAllResults();

        return view('admin/analytics', $data);
    }
}
