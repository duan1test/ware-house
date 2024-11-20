<?php

namespace App\Models;

use App\Traits\OrderHelpers;
use App\Models\AdjustmentItem;
use App\Traits\HasAttachments;
use App\Traits\HasManySyncable;

class Adjustment extends Model
{
    use HasAttachments;
    use HasManySyncable;
    use OrderHelpers;

    public static $hasReference = true;
    public static $hasUser = true;
    protected $fillable = [
        'date', 'reference',  'draft', 'type', 'warehouse_id', 'user_id', 'hash',
        'approved_by', 'account_id', 'details', 'extra_attributes', 'approved_at',
    ];
    protected $setHash = true;
    protected $setUser = true;

    // public function contact()
    // {
    //     return $this->belongsTo(Contact::class);
    // }

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

    public function items()
    {
        return $this->hasMany(AdjustmentItem::class)->orderBy('id')->withTrashed();
    }

    public function scopeFilters($query, $filters)
    {

        $query->when($filters['draft'], function ($query) use ($filters) {
            $query->drafts($filters['draft']=='yes' ? 1 : 0);
        });

        $query->when($filters['trashed'], function ($query) use ($filters) {
            $query->trashed($filters);
        });
 
        $query->when($filters['search'], function ($query) use ($filters) {
            $query->where(
                fn ($q) => $q->where('id', 'like', "%{$filters['search']}%")->orWhere('reference', 'like', "%{$filters['search']}%")
                ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")->orWhere('username', 'like', "%{$filters['search']}%"))
                ->orWhereHas('warehouse', fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")->orWhere('code', 'like', "%{$filters['search']}%"))
            );
        });

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
