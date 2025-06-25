<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $primaryKey = 'province_code';
    public $incrementing = false;

    protected $fillable = [
        'province_code',
        'province_name',
        'region_code',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'province_code', 'province_code');
    }

    public function brgys()
    {
        return $this->hasMany(Brgy::class, 'province_code', 'province_code');
    }
}
