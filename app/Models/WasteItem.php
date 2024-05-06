<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WasteItem extends Model
{
    use HasFactory;


    /**
     * Scope a query to search wastes
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('master_item_name', 'LIKE', "%{$search}%");
    }

    public function getCreatedAtViewAttribute(): string
    {
        return $this->created_at->format('d/m/Y h:i A');
    }
    public function getQuantityViewAttribute(): string
    {
        return $this->quantity . " " . Str::lower($this->unit);
    }

}
