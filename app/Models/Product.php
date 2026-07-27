<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'brand_id',
        'category_id',
        'product_code',
        'Chassis_number',
        'Engine_number',
        'Color',
        'Year',
        'price',
        'CC',
        'WD',
        'Transmission',
        'PickupYard',
        'Supplier',
        'ODOMeter',
        'Score',
        'AuctionGrade',
        'InvoiceNumber',
        'Status',
        'Remarks',
        'created_at',
        'updated_at',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            $brand = Brand::findOrFail($product->brand_id);

            // Counter scoped per brand, e.g. "product:01-01" -> 01-01-0001, 01-01-0002...
            $counterKey = 'product:'.$brand->brand_code;
            $next = Counter::nextNumber($counterKey);

            $product->product_code = $brand->brand_code.'-'
                .str_pad($next, 4, '0', STR_PAD_LEFT);

            if (empty($product->name)) {
                $product->name = Str::slug($product->name).'-'.Str::lower($product->product_code);
            }
        });

        static::updating(function (Product $product) {
            // Only touch the code if brand_id actually changed —
            // editing name/price/status shouldn't burn a new counter number.
            if ($product->isDirty('brand_id')) {
                $brand = Brand::findOrFail($product->brand_id);

                $counterKey = 'product:'.$brand->brand_code;
                $next = Counter::nextNumber($counterKey);

                $product->product_code = $brand->brand_code.'-'
                    .str_pad($next, 4, '0', STR_PAD_LEFT);

                // Note: the OLD product_code's number is never reclaimed —
                // codes only ever move forward, so no two products can ever
                // collide even if products are moved between brands often.
            }
        });
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
