<?php

namespace App\Exports;

use App\Models\Application;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Implements:
 * - FromQuery: Mengambil data dari query (lebih efisien)
 * - WithHeadings: Menambahkan baris header
 * - WithMapping: Mengubah/memformat data setiap baris
 */
class ApplicationsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $jobId;

    /**
     * Menerima $jobId dari controller saat class ini dibuat
     */
    public function __construct(int $jobId)
    {
        $this->jobId = $jobId;
    }

    /**
     * Query ini HANYA akan mengambil pelamar
     * untuk lowongan yang sedang dilihat.
     */
    public function query()
    {
        return Application::query()
            ->with(['user', 'job']) // Eager load relasi
            ->where('job_id', $this->jobId);
    }

    /**
     * [LATIHAN 7] Fungsi ini akan membuat baris Header
     */
    public function headings(): array
    {
        return [
            'ID Lamaran',
            'Nama Pelamar',
            'Email Pelamar',
            'Lowongan',
            'Perusahaan',
            'Status Lamaran',
            'Tanggal Melamar',
        ];
    }

    /**
     * [LATIHAN 7] Fungsi ini memformat data untuk setiap baris
     * @var Application $application
     */
    public function map($application): array
    {
        return [
            $application->id,
            $application->user->name,
            $application->user->email,
            $application->job->title,
            $application->job->company,
            $application->status,
            $application->created_at->format('Y-m-d H:i:s'),
        ];
    }
}