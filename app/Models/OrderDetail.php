<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // public function product()
    // {
    //     return $this->belongsTo(Product::class)->withTrashed();
    // }


        /**
     * Get the view price.
     *
     * @return string
     */
    public function getViewPriceAttribute(): string
    {
        return currency_format($this->price);
    }


        /**
     * Get the view total.
     *
     * @return string
     */
    public function getViewTotalAttribute(): string
    {
        return currency_format($this->total);
    }
}
