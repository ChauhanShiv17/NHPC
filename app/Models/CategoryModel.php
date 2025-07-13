<?php
namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_name'];

    public function getAllCategories()
    {
        return $this->orderBy('category_name', 'ASC')->findAll();
    }
}
