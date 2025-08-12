<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    // Admin Dashboard
    public function dashboard()
    {
        $this->requireLogin();
        $this->checkRole('admin');
        return view('admin/dashboard');
    }

    // Pending blogs
    public function pendingBlogs()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->where('is_approved', 0)->findAll();

        return view('admin/pending_blogs', $data);
    }

    // View single pending blog (full content)
    public function viewPendingBlog($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $blog = $model->where('id', $id)->where('is_approved', 0)->first();

        if (!$blog) {
            return redirect()->back()->with('error', 'Blog not found!');
        }

        return view('admin/view_pending_blog', ['blog' => $blog]);
    }

    // Approve blog
    public function approve($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $model = new BlogModel();
        $model->update($id, [
            'is_approved' => 1,
            'admin_review' => null
        ]);

        return redirect()->to('/admin/pending-blogs')->with('success', 'Blog approved.');
    }

    // Reject blog with admin review
    public function reject_with_review($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $review = $this->request->getPost('review');

        $model = new BlogModel();
        $model->update($id, [
            'is_approved' => -1,
            'admin_review' => $review
        ]);

        return redirect()->to('/admin/pending-blogs')->with('success', 'Blog rejected with review.');
    }

    // Pending admins
    public function pendingAdmins()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $userModel = new UserModel();
        $data['pendingAdmins'] = $userModel
            ->where('role', 'admin')
            ->where('is_approved', 0)
            ->findAll();

        return view('admin/pending_admins', $data);
    }

    // Approve admin
    public function approveAdmin($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $userModel = new UserModel();
        $userModel->update($id, ['is_approved' => 1]);

        return redirect()->to('/admin/pending-admins')->with('success', 'Admin approved.');
    }

    // Reject admin
    public function rejectAdmin($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $userModel = new UserModel();
        $userModel->update($id, ['is_approved' => -1]);

        return redirect()->to('/admin/pending-admins')->with('success', 'Admin rejected.');
    }

    public function viewPending($id)
{
    $blogModel = new \App\Models\BlogModel();
    $blog = $blogModel->find($id);

    if (!$blog) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog not found");
    }

    return view('admin/view_pending_blog', ['blog' => $blog]);
}


    // View all registered users
    public function allUsers()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $userModel = new UserModel();
        $blogModel = new BlogModel();

        $users = $userModel->findAll();

        foreach ($users as &$user) {
            if ($user['role'] === 'author') {
                $user['blog_count'] = $blogModel->where('author_id', $user['id'])->countAllResults();
            } else {
                $user['blog_count'] = '-';
            }
        }

        $data['allUsers'] = $users;

        return view('admin/all_users', $data);
    }

    // Remove user (block)
    public function removeUser($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $userModel = new UserModel();
        $userModel->update($id, ['is_approved' => -1]);

        return redirect()->to('/admin/all-users')->with('success', 'User removed (blocked).');
    }

    // View all approved blogs
    public function allBlogs()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel
            ->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/all_blogs', $data);
    }

    // View rejected blogs with author name
    public function rejectedBlogs()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $db = \Config\Database::connect();
        $builder = $db->table('blogs');
        $builder->select('blogs.*, users.username as author_name');
        $builder->join('users', 'blogs.author_id = users.id');
        $builder->where('blogs.is_approved', -1);
        $builder->orderBy('blogs.created_at', 'DESC');
        $query = $builder->get();
        $data['blogs'] = $query->getResultArray();

        return view('admin/rejected_blogs', $data);
    }

    // Old moderation dashboard (all blogs)
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->findAll();

        return view('admin/dashboard', $data);
    }
}
