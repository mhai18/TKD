<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventCategory extends Model
{
    protected $fillable = ['name'];

    public function tournaments(): HasMany
    {
        return $this->hasMany(KyorugiTournament::class);
    }
}

