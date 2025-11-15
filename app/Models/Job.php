<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'company',
        'salary',
    ];

    /**
     * Mendefinisikan relasi "one-to-many".
     * Satu lowongan (Job) bisa memiliki banyak lamaran (Application).
     * Ini adalah kebalikan dari relasi di App\Models\Application 
     */
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}