<?php

namespace App\Models\ShoppingCart;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'produto_id', 'quantidade', 'pago'];
}
