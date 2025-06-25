<?php

namespace App\Models;

use App\Traits\HasAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAddress;

    protected $fillable = [
        'date_started',
        'chapter_name',
        'coach_id',
        'province_code',
        'municipality_code',
        'brgy_code'
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
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

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
