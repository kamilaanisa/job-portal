<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels; 

    public $user;

    /**
     * Create a new job instance.
     */
    public function __construct($user)
    {
        //Simpan user ke property
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Tambahkan pengecekan untuk keamanan
        if (!$this->user) {
            Log::warning('SendWelcomeEmailJob dibatalkan: User tidak ditemukan.');
            return;
        }

        $email = new WelcomeEmail($this->user);
        
        
       Mail::to($this->user['email'])->send($email);
    }
}