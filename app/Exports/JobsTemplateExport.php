<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * [LATIHAN 8] Class ini hanya untuk membuat file Excel dengan header
 * untuk template import lowongan.
 */
class JobsTemplateExport implements WithHeadings
{
    /**
    * Mendefinisikan header sesuai dengan import class
    */
    public function headings(): array
    {
        // Sesuaikan dengan App\Imports\JobsImport
        return [
            'title',
            'description',
            'location',
            'company',
            'salary',
        ];
    }
}