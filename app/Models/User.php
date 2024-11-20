<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\LogActivityTrait;
use App\Traits\Paginatable;
use App\Traits\SearchableTrait;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\ScopeFilterTrashTrait;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LogActivityTrait;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use SearchableTrait;
    use ScopeFilterTrashTrait;
    use Paginatable;
    
    const WITH_TRASH = 'with';
    const ONLY_TRASH = 'only';
    const WITHOUT_TRASH = 'without';

    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'view_all', 'edit_all', 'warehouse_id', 'extra_attributes', 'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->account_id) {
                $model->account_id = auth()->user() ? auth()->user()->account_id : 1;
            }
        });
    }

    protected static function searchFields(): array
    {
        return ['name', 'email'];
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return in_array(SoftDeletes::class, class_uses($this))
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value);
    }

    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function del()
    {
        if ($this->checkins()->exists() || $this->checkouts()->exists()) {
            return false;
        }
        return $this->delete();
    }

    public function delP()
    {
        if ($this->checkins()->exists() || $this->checkouts()->exists()) {
            return false;
        }

        // log_activity(__choice('delete_text', ['record' => 'User']), $this, $this, 'User');
        $this->roles()->detach();
        return $this->forceDelete();
    }

    public function scopeOfAccount($query, $account_id = null)
    {
        return $query->where('account_id', $account_id ?? auth()->user()->account_id ?? 1);
    }
}
