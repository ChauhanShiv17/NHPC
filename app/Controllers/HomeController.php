<?php

namespace App\Controllers;

use App\Models\BlogModel;
use CodeIgniter\Controller;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ Force login before accessing homepage
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        helper('text');

        $model = new BlogModel();
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');

        $builder = $model->where('is_approved', 1);

        if ($search) {
            $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('content', $search)
                    ->groupEnd();
        }

        if ($category) {
            $builder->where('category', $category);
        }

        $data['blogs'] = $builder->orderBy('created_at', 'DESC')
                                 ->limit(10)
                                 ->findAll();

        $data['categories'] = $model->getCategories();
        $data['selectedCategory'] = $category ?? '';
        $data['searchTerm'] = $search ?? '';

        return view('home', $data);
    }
}
