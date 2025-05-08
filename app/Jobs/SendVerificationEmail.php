<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3; // Mencoba 3 kali jika gagal
    public $timeout = 60; // Timeout 60 detik
    public $maxExceptions = 3; // Maksimal 3 exception

    protected $user;
    protected $verificationToken;

    /**
     * Create a new job instance.
     */
    public function __construct($user, $verificationToken)
    {
        $this->user = $user;
        $this->verificationToken = $verificationToken;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Mencoba mengirim email ke: ' . $this->user->email);
            
            Mail::send('emails.verification', [
                'user' => $this->user,
                'token' => $this->verificationToken
            ], function($message) {
                $message->to($this->user->email)
                       ->subject('Verifikasi Email OrderIt');
            });
            
            Log::info('Email berhasil dikirim ke: ' . $this->user->email);
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Job gagal setelah beberapa percobaan: ' . $exception->getMessage());
    }
} 