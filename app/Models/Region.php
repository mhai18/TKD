<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $primaryKey = 'region_code';
    public $incrementing = false;

    protected $fillable = [
        'region_code',
        'region_name',
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_code', 'region_code');
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'region_code', 'region_code');
    }

    public function brgys()
    {
        return $this->hasMany(Brgy::class, 'region_code', 'region_code');
    }
}
