<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;

class Warehouse extends Model
{
    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';
    const FOLDER_IMAGE = 'warehouseLogos';
    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'address',
        'active',
        'logo',
        'location',
        'account_id',
    ];

    public function getLogo()
    {
        if($this->logo == null) {
            return getDefaultWarehouseImage();
        } else {
            return Storage::url('') . $this->logo;
        }
    }

    public function getActiveLabel() {
        return $this->active ? __('attributes.warehouse.active') : __('attributes.warehouse.inactive');
    }

    public function scopeFilters($query, $filters)
    {
        $query->when($filters['search'], function ($query) use ($filters) {
            $query->where(
                fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")->orWhere('code', 'like', "%{$filters['search']}%")
            );  
        });
        
        $query->when($filters['trashed'], function ($query) use ($filters) {
            $query->trashed($filters);
        });
    
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeOfAccount($query, $account = null)
    {
        return $query->where('account_id', $account ?? auth()->user()->account_id);
    }

    public function del()
    {
        if ($this->checkinItems()->exists() || $this->checkinItems()->exists() || $this->transferItems()->exists() || $this->adjustmentItems()->exists()) {
            return false;
        }
        return $this->delete();
    }
    
    public function delP()
    {
        if ($this->checkinItems()->exists() || $this->checkinItems()->exists() || $this->transferItems()->exists() || $this->adjustmentItems()->exists()) {
            return false;
        }
        if ($this->logo && \Storage::exists('public/' . $this->logo)) {
            \Storage::delete('public/' . $this->logo);
        }
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
}
