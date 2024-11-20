<?php

namespace App\Models;

use App\Models\Serial;
use App\Models\Variation;
use App\Models\StockTrail;
use App\Traits\ItemHelpers;
use App\Traits\Paginatable;
use App\Traits\SearchableTrait;
use App\Traits\UploadFileTrait;
use App\Traits\ScopeFilterTrashTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Item extends Model
{
    use HasFactory, UploadFileTrait, SearchableTrait, SoftDeletes, ScopeFilterTrashTrait, Paginatable, ItemHelpers;

    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';

    public $casts = [
        'variants'       => 'array',
        'has_serials'    => 'boolean',
        'has_variants'   => 'boolean',
        'track_quantity' => 'boolean',
        'track_weight'   => 'boolean',
    ];

    protected $fillable = [
        "category_id", 'name', 'code', 'symbology', 'track_weight', 'track_quantity', 'alert_quantity', 'rack_location', 'photo',
        'has_variants', 'variants', 'has_serials', 'sku', 'details', 'unit_id', 'account_id', 'extra_attributes',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public static function searchFields()
    {
        return [
            'name', 'code', 'sku'
        ];
    }

    public function getPhoto()
    {
        return $this->photo ? Storage::url($this->photo) : asset('assets/images/icons/defautl-img.png');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function stockTrails()
    {
        return $this->hasMany(StockTrail::class, 'item_id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class)->whereNull('variation_id');
    }

    public function allStock()
    {
        return $this->hasMany(Stock::class);
    }

    public function serials()
    {
        return $this->hasMany(Serial::class);
    }

    public function allVariations()
    {
        return $this->hasMany(Variation::class);
    }

    public function del()
    {
        if ($this->checkinItems()->exists() || $this->checkoutItems()->exists() || $this->adjustmentItems()->exists() || $this->transferItems()->exists()) {
            return false;
        }
        $this->variations->each->delete();
        $this->stockTrails->each->delete();
        $this->stock->each->delete();
        return $this->delete();
    }
    public function delP()
    {
        if ($this->checkinItems()->exists() || $this->checkoutItems()->exists() || $this->adjustmentItems()->exists() || $this->transferItems()->exists()) {
            return false;
        }
        $this->categories()->detach();
        $this->stockTrails()->forceDelete();
        $this->stock()->forceDelete();
        $this->serials()->forceDelete();
        $this->variations->each(function ($variation) {
            $variation->stock()->forceDelete();
        });
        $this->variations()->forceDelete();
        return $this->forceDelete();
    }

    public function checkinItems()
    {
       return $this->hasMany(CheckinItem::class);
    }

    public function checkoutItems()
    {
       return $this->hasMany(CheckoutItem::class);
    }

    public function adjustmentItems()
    {
       return $this->hasMany(AdjustmentItem::class);
    }

    public function transferItems()
    {
       return $this->hasMany(CheckoutItem::class);
    }

    public function scopeOfCategory($query, $category)
    {
        return $query->whereHas('categories', fn ($query) => $query->where('categories.id', $category));
    }

    public function scopeFilters($query, $filters)
    {
        $query->when($filters['trashed'] == Item::WITHOUT_TRASH, function ($query) {
            $query->withTrashed();
        })->when($filters['trashed'] == Item::ONLY_TRASH, function ($query) {
            $query->onlyTrashed();
        });

        $query->when($filters['search'], function ($query) use ($filters) {
            $query->where(
                fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")->orWhere('sku', 'like', "%{$filters['search']}%")
            );
        });

        return $query;
    }
}
