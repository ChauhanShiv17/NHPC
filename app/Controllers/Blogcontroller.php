<?php

namespace App\Controllers;

use App\Models\BlogModel;

class BlogController extends BaseController
{
    // Show form to create blog
    public function create()
    {
        $this->requireLogin(); // Ensure user is logged in
        $this->checkRole('author'); // Ensure user is an author

        $model = new BlogModel();
        $data['categories'] = $model->getCategories(); // Load categories for dropdown

        return view('blog/create', $data);
    }

    // Store the new blog post
    public function store()
    {
        $this->requireLogin(); // Ensure user is logged in
        $this->checkRole('author'); // Ensure user is an author

        $model = new BlogModel();

        $imageName = null;
        $image = $this->request->getFile('image');

        // Handle image upload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('uploads', $imageName);
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'content'     => $this->request->getPost('content'),
            'author_id'   => session()->get('user_id'), // Logged in author's ID
            'image'       => $imageName,
            'category'    => $this->request->getPost('category'),
            'is_approved' => 0 // Blog requires admin approval
        ];

        $model->insert($data);

        return redirect()->to('/blog/create')->with('message', 'Blog submitted for approval.');
    }

    // Show all approved blogs (with optional search)
    public function index()
    {
        $model = new BlogModel();
        $keyword = $this->request->getGet('search');

        if ($keyword) {
            $data['blogs'] = $model
                ->like('title', $keyword)
                ->orLike('content', $keyword)
                ->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        } else {
            $data['blogs'] = $model
                ->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll();
        }

        return view('blog/index', $data);
    }

    // Show blogs by category
    public function category($categoryName)
    {
        $model = new BlogModel();
        $data['blogs'] = $model->where('category', urldecode($categoryName))
                               ->where('is_approved', 1)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        $data['selectedCategory'] = $categoryName;

        return view('blog/category_blogs', $data);
    }

    // View individual blog post
    public function view($id)
    {
        $model = new BlogModel();
        $blog = $model->find($id);

        if (!$blog) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog with ID $id not found");
        }

        return view('blog/view', ['blog' => $blog]);
    }
}
