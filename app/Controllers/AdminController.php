<?php

namespace App\Controllers;

use App\Models\BlogModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    // Admin dashboard overview
    public function dashboard()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        return view('admin/home');
    }

    // Blog moderation list
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $data['blogs'] = $model->findAll();

        return view('admin/dashboard', $data);
    }

    public function approve($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $model->update($id, ['is_approved' => 1]);

        return redirect()->to('/admin');
    }

    public function reject($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $model->delete($id);

        return redirect()->to('/admin');
    }
}
