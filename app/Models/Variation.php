<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variation extends Model
{
    use HasFactory;

    public $casts = ['meta' => 'array'];
    protected $fillable = ['sku', 'item_id', 'rack_location', 'account_id', 'meta'];
    
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function getUnitAttribute()
    {
        return $this->pivot->unit_id ? Unit::find($this->pivot->unit_id) : null;
    }

}
