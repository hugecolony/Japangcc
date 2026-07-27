<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'category_code',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            // Auto-generate hierarchical code: 01, 02, 03...
            $next = Counter::nextNumber('category');
            $category->category_code = str_pad($next, 2, '0', STR_PAD_LEFT);

            if (empty($category->name)) {
                $category->name = Str::slug($category->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id', 'id');
    }
}
