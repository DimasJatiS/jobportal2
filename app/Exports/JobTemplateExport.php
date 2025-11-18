<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class JobTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'title',
            'description',
            'location',
            'company',
            'type',
            'salary',
        ];
    }
}
