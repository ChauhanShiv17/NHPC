<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\CategoryModel;

class BlogController extends BaseController
{
    // Show form to create blog
    public function create()
    {
        $this->requireLogin(); // Ensure user is logged in
        $this->checkRole('author'); // Ensure user is an author

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->getAllCategories();

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
            'author_id'   => session()->get('user_id'),
            'image'       => $imageName,
            'category'    => $this->request->getPost('category'),
            'is_approved' => 0
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
   // View individual blog post
public function view($id)
{
    $model = new BlogModel();
    $blog = $model->select('blogs.*, users.username as author_name')
                  ->join('users', 'users.id = blogs.author_id', 'left')
                  ->where('blogs.id', $id)
                  ->first();

    if (!$blog) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog with ID $id not found");
    }

    return view('blog/view', ['blog' => $blog]);
}


    // Search blogs and show homepage
    public function search()
    {
        $query = $this->request->getGet('q');

        $blogModel = new BlogModel();
        $blogs = $blogModel->like('title', $query)
                           ->orLike('content', $query)
                           ->where('is_approved', 1)
                           ->findAll();

        // ✅ Get all categories from CategoryModel instead of distinct from blog table
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        return view('home', [
            'blogs' => $blogs,
            'categories' => $categories,
            'query' => $query
        ]);
    }

    // Load more blogs for infinite scroll / load more
public function loadMore()
{
    $offset = $this->request->getGet('offset');
    $limit = 6; // number of blogs per load

    $blogModel = new \App\Models\BlogModel();
    $blogs = $blogModel
        ->where('is_approved', 1)
        ->orderBy('created_at', 'DESC')
        ->findAll($limit, $offset);

    return $this->response->setJSON($blogs);
}

// In app/Controllers/BlogController.php
public function searchSuggest()
{
    $query = $this->request->getGet('q');
    $blogModel = new \App\Models\BlogModel();

    $blogs = $blogModel
        ->like('title', $query)
        ->select('id, title, image')   // make sure 'image' is selected
        ->limit(5)
        ->findAll();

    return $this->response->setJSON($blogs);
}



}
