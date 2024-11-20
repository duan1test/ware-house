<?php

namespace App\Models;

use App\Models\Model;
use App\Models\Warehouse;
use App\Traits\OrderHelpers;
use App\Traits\HasAttachments;
use App\Traits\HasManySyncable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasAttachments;
    use HasManySyncable;
    use OrderHelpers;

    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';
    protected $fillable = [
        "date",
        "reference",
        "draft",
        "to_warehouse_id",
        "from_warehouse_id",
        "user_id",
        "details",
    ];

    public static $hasReference = true;
    protected $setUser = true;
    public static $hasUser = true;

    public function del()
    {
        $this->items->each->delete();
        return $this->delete();
    }

    public function delP()
    {
        // log_activity(__choice('delete_text', ['record' => 'Item']), $this, $this, 'Item');
        $this->items->each->forceDelete();
        return $this->forceDelete();
    }
    
    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transferItems() 
    {
        return $this->hasMany(TransferItem::class, 'transfer_id');
    }
    
    public function scopeFilters($query, $filters = [])
    {
        $query->when($filters['q'], function ($query) use ($filters) {
            $query->search($filters['q']);
        });
    
        $query->when($filters['draft'], function ($query) use ($filters) {
            $query->drafts($filters['draft']=='yes' ? 1 : 0);
        });

        $query->when($filters['trashed'], function ($query) use ($filters) {
            $query->trashed($filters);
        });
    
        return $query;
    }

    public function scopeSearch($query, $s)
    {
        $query->where(
            fn ($q) => $q->where('id', 'like', "%{$s}%")->orWhere('reference', 'like', "%{$s}%")
                ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('username', 'like', "%{$s}%"))
                ->orWhereHas('toWarehouse', fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%"))
                ->orWhereHas('fromWarehouse', fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%"))
        );
    }

    public function items()
    {
        return $this->hasMany(TransferItem::class)->orderBy('id')->withTrashed();
    }
}
