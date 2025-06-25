<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $primaryKey = 'municipality_code';
    public $incrementing = false;

    protected $fillable = [
        'municipality_code',
        'municipality_name',
        'region_code',
        'province_code',
        'zip_code',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function brgys()
    {
        return $this->hasMany(Brgy::class, 'municipality_code', 'municipality_code');
    }
}
