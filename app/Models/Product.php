<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasUuid, HasImage, HasStatus;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_path',
        'sale_price',
        'discount_price',
        'cost',
        'barcode',
        'sku',
        'quantity',
        'description',
        'sort_order',
        'is_active',
        'category_id',
    ];

    /**
     * Scope a query to search products
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }


    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }
    /**
     * Get the price.
     *
     * @return float
     */
    public function getPriceAttribute(): float
    {
        if ($this->discount_price > 0) {
            return $this->discount_price;
        }

        return $this->sale_price;
    }

    /**
     * Get the has discount.
     *
     * @return bool
     */
    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price > 0;
    }

    /**
     * Get the view price.
     *
     * @return string
     */
    public function getViewPriceAttribute(): string
    {
        return currency_format($this->price);
    }
}
