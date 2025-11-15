<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'cv',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * DIPERBARUI: Relasi sekarang ke JobVacancy,
     * menggunakan 'job_id' sebagai foreign key.
     */
    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_id');
    }
}