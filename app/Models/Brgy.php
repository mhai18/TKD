<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brgy extends Model
{
    use HasFactory;

    public $table = 'brgys';
    protected $primaryKey = 'brgy_code';
    public $incrementing = false;

    protected $fillable = [
        'brgy_code',
        'brgy_name',
        'region_code',
        'province_code',
        'municipality_code',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'region_code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_code', 'municipality_code');
    }
}
