<?php

namespace App\Models;

use App\Traits\Paginatable;
use App\Traits\LogActivityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Model extends Eloquent
{
    use LogActivityTrait;
    use HasFactory;
    use SoftDeletes;
    use Paginatable;

    protected $setUser = false;
    public static $hasReference = false;
    public static $hasUser = false;


    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';

    public function scopeOfAccount($query)
    {
        return $query->where('account_id', auth()->user()->account_id);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($this->getRouteKeyName(), $value)->withTrashed()->first();
    }

    protected static function booted()
    {
        static::addGlobalScope('account', function (Builder $builder) {
            $builder->where('account_id', getAccountId(1));
        });

        if (static::$hasUser) {
            static::addGlobalScope('mine', function (Builder $builder) {
                $user = auth()->user();
                if (!$user->hasRole('Super Admin') && !$user->view_all) {
                    $builder->where('user_id', $user->id);
                }
            });
        }

        static::creating(function ($model) {
            if (!$model->account_id) {
                $model->account_id = getAccountId();
            }
            if ($model->setUser && !$model->user_id) {
                $model->user_id = auth()->user()->id;
            }
            if ($model->setHash && !$model->hash) {
                $model->hash = uuid4();
            }
            if ($model::$hasReference && !$model->reference) {
                $model->reference = get_reference($model);
            }
        });
    }

    public static function scopeDrafts($query, $filter){
        $query->where('draft', $filter);
    }

    public static function scopeTrashed($query, $filters){
        $query->when($filters['trashed'] == Model::WITHOUT_TRASH, function ($query) {
            $query->withTrashed();
        })->when($filters['trashed'] == Model::ONLY_TRASH, function ($query) {
            $query->onlyTrashed();
        });
    }
}
