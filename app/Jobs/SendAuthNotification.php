<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendAuthNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $type; // 'register' atau 'login'

    /**
     * Create a new job instance.
     */
    public function __construct($user, $type)
    {
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info("Mengirim notifikasi {$this->type} untuk user: " . $this->user->email);
            
            $subject = $this->type === 'register' ? 'Selamat Datang di OrderIt!' : 'Login Berhasil di OrderIt';
            $template = $this->type === 'register' ? 'emails.welcome' : 'emails.login-notification';
            
            Mail::send($template, [
                'user' => $this->user,
                'time' => now()->format('d M Y H:i:s'),
                'ip' => request()->ip()
            ], function($message) use ($subject) {
                $message->to($this->user->email)
                       ->subject($subject);
            });
            
            Log::info("Notifikasi {$this->type} berhasil dikirim ke: " . $this->user->email);
        } catch (\Exception $e) {
            Log::error("Error mengirim notifikasi: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("Job gagal: " . $exception->getMessage());
    }
} 