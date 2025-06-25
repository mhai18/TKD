<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PomsaeMatch extends Model
{
    protected $fillable = [
        'tournament_id',
        'player_id',
        'division',
        'belt_level',
        'gender',
        'category',
        'poomsae_performed',
        'accuracy_score',
        'presentation_score',
        'total_score',
        'performance_time',
        'round',
        'status',
    ];

    public function tournament()
    {
        return $this->belongsTo(PomsaeTournament::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
