<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'birthday',
        'gender',
        'nationality',
        'civil_status',
        'email',
        'telephone',
        'mobile',
        'fax',
        'street_address',
        'city',
        'state',
        'country',
        'zip_code',
        'tax_identification_number',
        'notes',
        'company_name',
        'company_street_address',
        'company_city',
        'company_state',
        'company_country',
        'company_zip_code'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function order_details()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class);
    }


    /**
     * Scope a query to search customers
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%{$search}%");
    }



    public function getOwedAmountAttribute(): string
    {
        $change = $this->orders->where('change', '<', '0')->sum('change');
        // if ($change < 0) {
        //     return currency_format(abs($change));
        // }
        return currency_format(abs($change));
        //return 0;
    }

    public function getPurchaseAmountAttribute(): string
    {
        $purchaseAmount = $this->orders->sum('total');
        return $purchaseAmount <= 0 ? 0 : currency_format($purchaseAmount);
    }
    public function getTotalOrdersAttribute(): string
    {
        return $this->orders->count();
    }
    public function getIsMaleAttribute(): bool
    {
        return $this->gender == "male";
    }
    public function getIsFemaleAttribute(): bool
    {
        return $this->gender == "female";
    }
}
