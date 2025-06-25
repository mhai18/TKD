<?php

namespace App\Models;

use App\Enums\TournamentStatus;
use App\Traits\HasAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class KyorugiTournament extends Model implements HasMedia
{
    use HasAddress;
    use InteractsWithMedia;

    protected $fillable = [
        'event_category_id',
        'name',
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
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class, 'kyorugi_tournament_player', 'tournament_id', 'player_id')
            ->withPivot(['weight_class', 'belt_level', 'status', 'registered_by'])
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'municipality_code');
    }

    public function barangay()
    {
        return $this->belongsTo(Brgy::class, 'brgy_code', 'brgy_code');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function match()
    {
        return $this->hasOne(KyorugiTournamentMatch::class, 'tournament_id');
    }

    public function matches()
    {
        return $this->hasMany(KyorugiTournamentMatch::class, 'tournament_id');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->optimize()
            ->performOnCollections('banner');

        $this->addMediaConversion('web_thumbnail')
            ->width(360)
            ->height(360)
            ->optimize()
            ->performOnCollections('banner');

        $this->addMediaConversion('responsive')
            ->height(720)
            ->width(720)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('banner');
    }
}
