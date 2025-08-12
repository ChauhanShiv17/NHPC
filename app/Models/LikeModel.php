<?php
namespace App\Models;
use CodeIgniter\Model;

class LikeModel extends Model
{
    protected $table = 'likes';
    protected $allowedFields = ['blog_id', 'user_id'];
}
