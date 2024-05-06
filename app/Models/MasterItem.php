<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MasterItem extends Model
{
    use HasFactory, HasUuid, SoftDeletes;



    public function getInStockViewAttribute(): string
    {
        return $this->in_stock . " " . Str::lower($this->unit);
    }
    public function getUnitViewAttribute(): string
    {
        return $this->unit . " (" . Unit::$unitTexts[$this->unit] . ")";
    }
}
