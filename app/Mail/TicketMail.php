<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public \App\Models\Reservasi $reservasi;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\Reservasi $reservasi)
    {
        $this->reservasi = $reservasi;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket Reservasi Rumah Sejarah - ' . $this->reservasi->kode_tiket,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromStorageDisk('local', $this->reservasi->qr_code_path)
                ->as('tiket_qrcode_' . $this->reservasi->kode_tiket . '.svg')
                ->withMime('image/svg+xml'),
        ];
    }
}
