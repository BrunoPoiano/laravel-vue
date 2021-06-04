<?php

namespace App\Models\BlogApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPosts extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'titulo', 'secao_id', 'conteudo', 'path', 'tags'];
}
