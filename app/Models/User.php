<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasFullName;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFullName;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'email',
        'contact_number',
        'user_type',
        'password',
    ];

    protected $casts = [
        'user_type' => UserType::class,
    ];

    public function committee()
    {
        return $this->hasOne(Committee::class);
    }

    public function player()
    {
        return $this->hasOne(Player::class);
    }

    public function chapter()
    {
        return $this->hasOne(Chapter::class, 'coach_id');
    }

    public function kyorugiTournaments()
    {
        return $this->hasMany(KyorugiTournament::class, 'created_by');
    }

    public function registeredTournaments()
    {
        return $this->hasMany(KyorugiTournamentPlayer::class, 'registered_by');
    }

    public function redMatches()
    {
        return $this->hasMany(KyorugiTournamentMatch::class, 'player_red_id');
    }

    public function blueMatches()
    {
        return $this->hasMany(KyorugiTournamentMatch::class, 'player_blue_id');
    }

    public function wonMatches()
    {
        return $this->hasMany(KyorugiTournamentMatch::class, 'winner_id');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(200)
            ->height(200)
            ->optimize()
            ->performOnCollections('avatar');

        $this->addMediaConversion('web_thumbnail')
            ->width(360)
            ->height(360)
            ->optimize()
            ->performOnCollections('avatar');

        $this->addMediaConversion('responsive')
            ->height(720)
            ->width(720)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('avatar');
    }
}
