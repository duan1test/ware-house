<?php

namespace App\Models;
use App\Traits\Paginatable;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use Paginatable;
    
    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';
    protected $fillable = [
        'code',
        'name',
        'parent_id',
        'account_id',
    ];

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->child()->with('children');
    }

    public function del()
    {
        if($this->child()->exists() || $this->items()->exists()) {
            return false;
        }
        
        $this->child->each->delete();
        return $this->delete();
    }

    public function delP()
    {
        if ($this->child()->exists() || $this->items()->exists()) {
            return false;
        }

        $this->child->each->forceDelete();
        return $this->forceDelete();
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function items()
    {
        return $this->morphedByMany(Item::class, 'categorizable');
    }

    public static function scopeOnlyParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeFilters($query, $filters)
    {
        $query->when($filters['search'], function ($query) use ($filters) {
            $query->where(
                fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('code', 'like', "%{$filters['search']}%")
            );
        });
    
        $query->when($filters['trashed'], function ($query) use ($filters) {
            $query->trashed($filters);
        });

        $query->when($filters['parents'] && $filters['parents'] !== 'all', function ($query) use ($filters) {
            $query->where('parent_id', $filters['parents']);
        });
    
        return $query;
    }
    
}
