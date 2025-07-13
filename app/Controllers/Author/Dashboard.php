<?php

namespace App\Controllers\Author;

use App\Controllers\BaseController;
use App\Models\BlogModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('author');

        $model = new BlogModel();
        $authorId = session()->get('user_id');

        $data['blogs'] = $model->where('author_id', $authorId)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        return view('author/dashboard', $data);
    }

    public function rejectedBlogs()
{
    $this->requireLogin();
    $this->checkRole('author');

    $model = new \App\Models\BlogModel();
    $authorId = session()->get('user_id');

    $data['blogs'] = $model->where('author_id', $authorId)
                           ->where('is_approved', -1)
                           ->orderBy('created_at', 'DESC')
                           ->findAll();

    return view('author/rejected_blogs', $data);
}



}
