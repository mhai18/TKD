<?php

namespace App\Models;

use App\Enums\BeltLevel;
use App\Enums\Division;
use App\Enums\MatchStatus;
use App\Enums\WeightCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KyorugiTournamentMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'division',
        'weight_class',
        'belt_level',
        'gender',
        'player_red_id',
        'player_blue_id',
        'winner_id',
        'round',
        'match_status',
        'match_datetime',
    ];

    protected $casts = [
        'match_status' => MatchStatus::class,
        'division' => Division::class,
        'weight_class' => WeightCategory::class,
        'belt_level' => BeltLevel::class,
    ];

    // protected $with = [
    //     'player_red_id',
    //     'player_blue_id',
    // ];

    public function loser(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'loser_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tournament()
    {
        return $this->belongsTo(KyorugiTournament::class);
    }

    public function redPlayer()
    {
        return $this->belongsTo(User::class, 'player_red_id');
    }

    public function bluePlayer()
    {
        return $this->belongsTo(User::class, 'player_blue_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function getIsByeAttribute(): bool
    {
        return is_null($this->player_blue_id) || is_null($this->bluePlayer);
    }

    public function getGroupKey(): string
    {
        return implode('-', [
            $this->division->value,
            $this->weight_class->value,
            $this->belt_level->value,
            $this->gender,
        ]);
    }

    public function scopeByRound($query, int $round)
    {
        return $query->where('round', $round);
    }
}
