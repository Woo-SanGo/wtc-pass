<?php

namespace App\Exports;

use App\Models\ShelterApplication;
use Maatwebsite\Excel\Concerns\FromCollection;

class ShelterApplicationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ShelterApplication::all();
    }
}
