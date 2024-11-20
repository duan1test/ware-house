<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone','details',
    ];

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

        // log_activity(__choice('delete_text', ['record' => 'Contact']), $this, $this, 'Contact');
        return $this->forceDelete();
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, fn ($q, $t) => $q->{$t . 'Trashed'}())
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->search($search));
    }

    public function scopeSearch($query, $s)
    {
        $query->where(fn ($q) => $q->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%")->orWhere('phone', 'like', "%{$s}%"));
    }

    public function scopeFilters($query, $filters)
    {
        $query->when($filters['trashed'], function ($query) use ($filters) {
            $query->trashed($filters);
        });

        $query->when($filters['search'], function ($query) use ($filters) {
            $query->where(
                fn ($q) => $q->where('name', 'like', "%{$filters['search']}%")->orWhere('email', 'like', "%{$filters['search']}%")->orWhere('phone', 'like', "%{$filters['search']}%")
            );
        });

        return $query;
    }
}
