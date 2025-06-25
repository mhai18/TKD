<?php

namespace App\Models;

use App\Enums\BeltLevel;
use App\Enums\CivilStatus;
use App\Enums\Religion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasAddress;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
    use HasAddress;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_id',
        'pta_id',
        'ncc_id',
        'birth_date',
        'gender',
        'civil_status',
        'belt_level',
        'religion',
        'province_code',
        'municipality_code',
        'brgy_code',
    ];

    protected $casts = [
        'civil_status' => CivilStatus::class,
        'belt_level' => BeltLevel::class,
        'religion' => Religion::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
}
