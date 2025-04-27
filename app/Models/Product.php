<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Product Model
 * Represents a product in the system with its associated attributes and relationships.
 *
 * @property int    $id          Primary key
 * @property string $name        Name of the product
 * @property string $description Optional description of the product
 * @property float  $price       Price of the product
 * @property int    $quantity    Available quantity in stock
 * @property int    $user_id     ID of the user who owns this product
 * @property Carbon $created_at  Timestamp of creation
 * @property Carbon $updated_at  Timestamp of last update
 */
class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'quantity',
    ];

    /**
     * Get the user that owns the product.
     * Defines the relationship between Product and User models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
