<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $jobId;

    public function __construct($jobId = null)
    {
        $this->jobId = $jobId;
    }

    //  Ambil data murni (MODEL)
    public function collection()
    {
        return Application::with('user', 'job')
            ->when($this->jobId, fn($q) => $q->where('job_id', $this->jobId))
            ->get();
    }

    //  Judul kolom Excel
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelamar',
            'Lowongan',
            'Status',
            'CV (Link)',
            'Tanggal Lamar',
        ];
    }

    //  Mapping tiap baris ke kolom Excel
    public function map($app): array
    {
        return [
            $app->id,
            $app->user->name ?? '-',
            $app->job->title ?? '-',
            $app->status,
            asset('storage/' . $app->cv),
            $app->created_at->format('d-m-Y H:i'),
        ];
    }
}
