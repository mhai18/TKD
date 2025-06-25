<?php

namespace App\Models;

use App\Enums\TournamentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PomsaeTournament extends Model
{
    protected $fillable = [
        'name',
        'event_category_id',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
        'venue_name',
        'province_code',
        'municipality_code',
        'brgy_code',
        'created_by',
        'status',
        'remarks',
    ];

    protected $casts = [
        'status' => TournamentStatus::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_start' => 'date',
        'registration_end' => 'date',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(PomsaeTournamentPlayer::class, 'tournament_id');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(PomsaeMatch::class, 'tournament_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'municipality_code');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Brgy::class, 'brgy_code', 'brgy_code');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
