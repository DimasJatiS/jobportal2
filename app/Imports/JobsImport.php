<?php

namespace App\Imports;

use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Lewati baris kosong
        if (!isset($row['title']) || empty($row['title'])) {
            return null;
        }

        return new JobVacancy([
            'title'       => $row['title'],
            'description' => $row['description'],
            'location'    => $row['location'],
            'company'     => $row['company'],
            'salary'      => $row['salary'] ?? null,
        ]);
    }
}
