<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'product_category';

    protected $fillable = [
        'id',
        'name',
    ];

    protected $keyType = 'string';
}
