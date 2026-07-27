<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';

    protected $fillable = [
        'name',
        'category_id',
        'created_at',
        'updated_at',
        'brand_code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Brand $brand) {
            $category = Category::findOrFail($brand->category_id);

            // Counter scoped per category, e.g. "brand:01" -> 01-01, 01-02...
            $counterKey = 'brand:'.$category->category_code;
            $next = Counter::nextNumber($counterKey);

            $brand->brand_code = $category->category_code.'-'
                .str_pad($next, 2, '0', STR_PAD_LEFT);

            if (empty($brand->name)) {
                $brand->name = Str::slug($brand->name).'-'.Str::lower($brand->brand_code);
            }
        });
        static::updating(function (Brand $brand) {
            if ($brand->isDirty('category_id')) {
                $category = Category::findOrFail($brand->category_id);
                $counterKey = 'brand:'.$category->category_code;
                $next = Counter::nextNumber($counterKey);

                $brand->brand_code = $category->category_code.'-'
                    .str_pad($next, 2, '0', STR_PAD_LEFT);
            }
        });

    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
