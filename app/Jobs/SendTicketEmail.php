<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use App\Models\Reservasi;

class SendTicketEmail implements ShouldQueue
{
    use Queueable;

    public Reservasi $reservasi;

    /**
     * Create a new job instance.
     */
    public function __construct(Reservasi $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->reservasi->email)->send(new TicketMail($this->reservasi));
    }
}
