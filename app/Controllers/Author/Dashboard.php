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

        $model = new BlogModel();
        $authorId = session()->get('user_id');

        // Get rejected blogs (is_approved = -1) including admin_review field
        $data['blogs'] = $model->select('id, title, content, image, category, admin_review')
                               ->where('author_id', $authorId)
                               ->where('is_approved', -1)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        return view('author/rejected_blogs', $data);
    }

    // Show edit form for rejected blog
    public function editRejected($id)
    {
        $this->requireLogin();
        $this->checkRole('author');

        $model = new BlogModel();
        $blog = $model->where('id', $id)
                      ->where('author_id', session()->get('user_id'))
                      ->where('is_approved', -1)
                      ->first();

        if (!$blog) {
            return redirect()->to('/author/rejectedBlogs')->with('error', 'Blog not found or access denied.');
        }

        return view('author/edit_rejected_blog', ['blog' => $blog]);
    }

    // Handle update & resubmit rejected blog
    public function updateRejected($id)
    {
        $this->requireLogin();
        $this->checkRole('author');

        $model = new BlogModel();
        $blog = $model->where('id', $id)
                      ->where('author_id', session()->get('user_id'))
                      ->first();

        if (!$blog) {
            return redirect()->to('/author/rejectedBlogs')->with('error', 'Blog not found.');
        }

        // Update blog fields and set is_approved back to pending (0)
        $model->update($id, [
            'title'         => $this->request->getPost('title'),
            'content'       => $this->request->getPost('content'),
            'is_approved'   => 0,            // back to pending
            'admin_review'  => null          // clear old review
        ]);

        return redirect()->to('/author/rejectedBlogs')->with('message', 'Blog updated and sent for approval again!');
    }
}
