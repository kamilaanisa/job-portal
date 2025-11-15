<?php

namespace App\Imports;

// UBAH: Gunakan JobVacancy
use App\Models\JobVacancy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['title'])) {
            return null;
        }

        // UBAH: Buat model JobVacancy
        return new JobVacancy([
            'title'       => $row['title'],
            'description' => $row['description'] ?? null,
            'location'    => $row['location'] ?? null,
            'company'     => $row['company'] ?? null,
            'salary'      => $row['salary'] ?? null,
        ]);
    }
}