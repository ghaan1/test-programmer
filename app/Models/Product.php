<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'fk_product_category',
        'price',
        'selling_price',
        'stock',
        'image',
    ];

    protected $keyType = 'string';

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'fk_product_category');
    }
}