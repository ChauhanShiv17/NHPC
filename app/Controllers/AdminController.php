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
        return view('admin/dashboard'); // main dashboard view
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

    // Approve blog
    public function approve($id)
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $blogModel->update($id, ['is_approved' => 1]);

        return redirect()->to('/admin/pending-blogs')->with('success', 'Blog approved.');
    }

    // Reject blog
    public function reject($id)
{
    $this->requireLogin();
    $this->checkRole('admin');

    $blogModel = new BlogModel();
    $blogModel->update($id, [
        'is_approved' => -1,
        'rejected_by' => 'admin'
    ]);

    return redirect()->to('/admin/pending-blogs')->with('success', 'Blog rejected.');
}


    // Old moderation (not needed, but kept)
    public function index()
    {
        $this->requireLogin();
        $this->checkRole('admin');

        $blogModel = new BlogModel();
        $data['blogs'] = $blogModel->findAll();

        return view('admin/dashboard', $data);
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



}
