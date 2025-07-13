<?php

namespace App\Models;
use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'content',
        'author_id',
        'image',
        'category',
        'is_approved',
        'created_at'
    ];

    protected $useTimestamps = true;

    // 🔍 Search blogs by keyword (in title or content)
    public function searchBlogs($keyword)
    {
        return $this->like('title', $keyword)
                    ->orLike('content', $keyword)
                    ->where('is_approved', 1)
                    ->findAll();
    }

    // 📂 Get all distinct blog categories (approved only)
    public function getCategories()
    {
        return $this->select('category')
                    ->distinct()
                    ->where('is_approved', 1)
                    ->where('category !=', '') // avoid empty strings
                    ->where('category IS NOT NULL', null, false) // avoid NULL
                    ->orderBy('category', 'ASC')
                    ->findAll();
    }

    // 📚 Get blogs by category
    public function getBlogsByCategory($category)
    {
        return $this->where('category', $category)
                    ->where('is_approved', 1)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
