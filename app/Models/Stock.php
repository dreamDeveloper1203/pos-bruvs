<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Stock extends Model
{
    use HasFactory, HasUuid, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'master_item_name',
        'quantity',
        'total_price',
        'unit',
        'vendor_id',
        'notes',
    ];
    /**
     * Scope a query to search wastes
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('master_item_name', 'LIKE', "%{$search}%");
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }
    /**
     * Get the view total price.
     *
     * @return string
     */
    public function getViewTotalPriceAttribute(): string
    {
        return currency_format($this->total_price);
    }

    public function getCreatedAtViewAttribute(): string
    {
        return $this->created_at->format('d/m/Y h:i A');
    }

    public function getQuantityViewAttribute(): string
    {
        return $this->quantity . " " . Str::lower($this->unit);
    }

    public function getPricePerUnitAttribute(): string
    {
        if ($this->quantity > 0 && $this->total_price > 0) {
            return currency_format($this->total_price / $this->quantity);
        }
        return "";
    }
}
