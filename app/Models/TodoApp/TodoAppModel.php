<?php

namespace App\Models\TodoApp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoAppModel extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'nome'];

}
