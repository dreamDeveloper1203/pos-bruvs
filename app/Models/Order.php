<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * Scope a query to search orders
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('number', 'LIKE', "%{$search}%")->orWhereHas('customer', function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getCostAttribute(): float
    {
        return $this->order_details->sum('total_cost');
    }
    public function getTotalQuantityAttribute(): float
    {
        return $this->order_details->sum('quantity');
    }
    public function getCostViewAttribute(): string
    {
        return currency_format($this->cost);
    }

    public function getProfitAttribute(): float
    {
        return $this->order_details->sum('total') - $this->cost - $this->discount;
    }

    public function getProfitViewAttribute(): string
    {
        return currency_format($this->profit);
    }

    public function getChangeViewAttribute(): string
    {
        return $this->change > 0 ? currency_format($this->change) : "-";
    }

    public function getOweAttribute(): float
    {
        if ($this->tender_amount < $this->total) {
            return abs($this->tender_amount - $this->total);
        }
        return 0;
    }
    public function getOweViewAttribute(): string
    {
        return $this->owe > 0 ? currency_format($this->owe) :  "-";
    }
    public function getTenderAmountViewAttribute(): string
    {
        return currency_format($this->tender_amount);
    }

    public function getTotalViewAttribute(): string
    {
        return currency_format($this->total);
    }
    public function getSubTotalViewAttribute(): string
    {
        return currency_format($this->subtotal);
    }
    public function getDiscountViewAttribute(): string
    {
        return $this->discount > 0 ? currency_format($this->discount) : "-";
    }
    public function getDeliveryChargeViewAttribute(): string
    {
        return $this->delivery_charge > 0 ? currency_format($this->delivery_charge) : "-";
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->has_customer ? $this->customer->name : "-";
    }

    public function getHasCustomerAttribute(): bool
    {
        return !is_null($this->customer);
    }
    public function getHasTableAttribute(): bool
    {
        return !is_null($this->table_name);
    }
    public function getTableNameViewAttribute(): string
    {
        return $this->has_table ? $this->table_name : "-";
    }
    public function getHasTableStatusAttribute(): bool
    {
        return !is_null($this->table_status);
    }

    public function getTableStatusViewAttribute(): string
    {
        return $this->has_table_status ? $this->table_status : "";
    }
    public function getTableStatusPendingAttribute(): bool
    {
        return $this->table_status == 'pending';
    }

    public function getCreatedAtViewAttribute(): string
    {
        return $this->created_at->format('d/m/Y h:i A');
        // return $this->created_at->format('d M Y H:i');
    }
    public function getDateViewAttribute(): string
    {
        return $this->created_at->format('d/m/Y');
    }
    public function getTimeViewAttribute(): string
    {
        return $this->created_at->format('h:i:s A');
    }

    public function getTaxAmountAttribute(): float
    {
        if ($this->tax_rate <= 0) return 0;
        $grossAmount = $this->subtotal - $this->discount;
        $taxAmount = (1 + ($this->tax_rate / 100));
        $value = $grossAmount / $taxAmount;
        return (float)number_format($value, 0, '', '');
    }
    public function getVatAttribute(): float
    {
        return $this->subtotal - $this->tax_amount - $this->discount;
    }


}
