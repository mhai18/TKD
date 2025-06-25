<?php

namespace App\Traits;

use App\Models\Province;
use App\Models\Municipality;
use App\Models\Brgy;

trait HasAddress
{
    public function getProvince(): ?Province
    {
        return Province::where('province_code', $this->province_code)->first();
    }

    public function getMunicipality(): ?Municipality
    {
        return Municipality::where('municipality_code', $this->municipality_code)->first();
    }

    public function getBarangay(): ?Brgy
    {
        return Brgy::where('brgy_code', $this->brgy_code)->first();
    }

    public function getFullAddressAttribute(): string
    {
        $brgy = $this->getBarangay()?->brgy_name;
        $municipality = $this->getMunicipality()?->municipality_name;
        $province = $this->getProvince()?->province_name;

        // Join non-null values with a comma
        return collect([$brgy, $municipality, $province])
            ->filter()
            ->implode(', ');
    }
}
