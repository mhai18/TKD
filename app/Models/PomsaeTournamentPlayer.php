<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PomsaeTournamentPlayer extends Model
{
    protected $fillable = [
        'tournament_id',
        'player_id',
        'division',
        'belt_level',
        'gender',
        'category',
        'registered_by'
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    public function tournament()
    {
        return $this->belongsTo(PomsaeTournament::class);
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
