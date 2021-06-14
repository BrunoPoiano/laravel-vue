<?php

namespace App\Models\ShoppingCart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoSc extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'quantidade', 'preco', 'user_id'];

}
