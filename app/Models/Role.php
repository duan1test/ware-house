<?php

namespace App\Models;

use App\Traits\Paginatable;
use App\Traits\SearchableTrait;
use App\Traits\LogActivityTrait;
use App\Interfaces\ConstantModel;
use App\Traits\ScopeFilterTrashTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as BaseRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseRole
{
    use LogActivityTrait;
    use HasFactory;
    use SoftDeletes;
    use ScopeFilterTrashTrait;
    use SearchableTrait;
    use Paginatable;

    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ('with' === $trashed) {
                $query->withTrashed();
            } elseif ('only' === $trashed) {
                $query->onlyTrashed();
            }
        });
    }

    public function scopeOfAccount($query)
    {
        return $query->where('account_id', auth()->user()->account_id);
    }
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->account_id) {
                $model->account_id = auth()->user()->account_id;
            }
        });
    }

    public function getStatusLabel()
    {
        return $this->deleted_at ? __('common.role.only_trashed') : __('common.role.not_trashed');
    }

    protected static function searchFields(): array
    {
        return ['name'];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    public function delP()
    {
        // log_activity(__choice('delete_text', ['record' => 'Role']), $this, $this, 'Role');
        $this->users()->detach();
        return $this->forceDelete();
    }

    public function del()
    {
        if ($this->users()->exists() || 'Super Admin' == $this->name) {
            return false;
        }
        return $this->delete();
    }
}
