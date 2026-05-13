<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PermohonananDatasetsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private $id_tracking, private $judul, private $nama)
    {
        //
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Permohonan Datasets Berhasil Terkirim',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.permohonan-data.masuk',
            with: [
                'id_tracking' => $this->id_tracking,
                'judul' => $this->judul,
                'nama' => $this->nama,
            ],
        );
    }
}
