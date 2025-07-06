<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $data['blogs'] = $model->findAll(); // all blogs

        return view('admin/dashboard', $data);
    }
}
