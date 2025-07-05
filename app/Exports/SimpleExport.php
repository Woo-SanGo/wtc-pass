<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SimpleExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['1', 'Test Organization', 'test@example.com', '1234567890', 'Test Address', 'pending'],
            ['2', 'Another Organization', 'another@example.com', '0987654321', 'Another Address', 'approved'],
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Organization Name',
            'Email',
            'Phone',
            'Address',
            'Status'
        ];
    }
} 