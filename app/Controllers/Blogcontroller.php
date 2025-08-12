<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\CategoryModel;
use App\Models\LikeModel;
use App\Models\CommentModel;
use App\Libraries\AIModerator;

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
        $this->requireLogin();
        $this->checkRole('author');

        $model = new BlogModel();

        $imageName = null;
        $image = $this->request->getFile('image');

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
                ->findAll(10, 0);
        } else {
            $data['blogs'] = $model
                ->where('is_approved', 1)
                ->orderBy('created_at', 'DESC')
                ->findAll(10, 0);
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
        $blog = $model->select('blogs.*, users.username as author_name')
                      ->join('users', 'users.id = blogs.author_id', 'left')
                      ->where('blogs.id', $id)
                      ->first();

        if (!$blog) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Blog with ID $id not found");
        }

        // Get like count
        $likeModel = new LikeModel();
        $likeCount = $likeModel->where('blog_id', $id)->countAllResults();

        // Get comments
        $commentModel = new CommentModel();
        $comments = $commentModel
            ->select('comments.*, users.username')
            ->join('users', 'users.id = comments.user_id', 'left')
            ->where('blog_id', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('blog/view', [
            'blog' => $blog,
            'likeCount' => $likeCount,
            'comments' => $comments
        ]);
    }

    // Add a new comment (with AI moderation)
    public function comment($blogId)
    {
        $commentText = $this->request->getPost('comment');
        $userId = session()->get('user_id');

        $moderator = new AIModerator();
        if ($moderator->checkInappropriate($commentText)) {
            $model = new CommentModel();
            $model->insert([
                'blog_id' => $blogId,
                'user_id' => $userId,
                'comment' => $commentText
            ]);
            return redirect()->back()->with('message', 'Comment added!');
        } else {
            return redirect()->back()->with('error', 'Your comment has inappropriate content.');
        }
    }

    public function loadComments($blogId)
{
    $offset = $this->request->getGet('offset') ?? 0;
    $commentModel = new \App\Models\CommentModel();
    $comments = $commentModel
        ->select('comments.*, users.username')
        ->join('users', 'users.id = comments.user_id', 'left')
        ->where('blog_id', $blogId)
        ->orderBy('created_at', 'DESC')
        ->findAll(10, $offset);
    return $this->response->setJSON($comments);
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
        $limit = 6;

        $blogModel = new BlogModel();
        $blogs = $blogModel
            ->where('is_approved', 1)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit, $offset);

        return $this->response->setJSON($blogs);
    }

    // Search suggestions for autocomplete
    public function searchSuggest()
    {
        $query = $this->request->getGet('q');
        $blogModel = new BlogModel();

        $blogs = $blogModel
            ->like('title', $query)
            ->select('id, title, image')
            ->limit(5)
            ->findAll();

        return $this->response->setJSON($blogs);
    }

    // Like / Unlike toggle
    public function like($blogId)
    {
        $likeModel = new LikeModel();
        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->back()->with('error', 'You must be logged in to like a blog.');
        }

        $existingLike = $likeModel
            ->where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            // Unlike
            $likeModel->delete($existingLike['id']);
            return redirect()->back()->with('message', 'You disliked this blog.');
        } else {
            // Like
            $likeModel->insert([
                'blog_id' => $blogId,
                'user_id' => $userId
            ]);
            return redirect()->back()->with('message', 'You liked this blog!');
        }
    }



    // Upload image (e.g., from CKEditor)
    public function uploadImage()
    {
        $file = $this->request->getFile('upload');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (! in_array($file->getMimeType(), $allowedTypes)) {
                return $this->response->setJSON(['error' => ['message' => 'Invalid image type']]);
            }

            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);

            $url = base_url('uploads/' . $newName);

            return $this->response->setJSON(["url" => $url]);
        }


        return $this->response->setJSON(["error" => ["message" => "Could not upload image"]]);
    }
}
