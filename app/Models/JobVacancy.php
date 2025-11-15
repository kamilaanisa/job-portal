<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang benar.
     */
    protected $table = 'job_vacancies';

    /**
     * Kolom yang boleh diisi.
     */
    protected $fillable = [
        'title',
        'description',
        'company',
        'location',
        'salary',
    ];

    /**
     * Relasi ke applications.
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}