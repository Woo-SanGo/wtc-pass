<?php

namespace App\Exports;

use App\Models\ShelterApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShelterApplicationsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ShelterApplication::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Organization Name',
            'Email',
            'Phone',
            'Address',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->organization_name,
            $row->email,
            $row->phone,
            $row->address,
            $row->status,
            $row->created_at,
            $row->updated_at
        ];
    }
}
