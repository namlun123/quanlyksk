<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment; // Đây là thuộc tính để chứa dữ liệu truyền vào

    /**
     * Create a new message instance.
     *
     * @param array $appointment
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận đăng ký lịch hẹn')
                    ->view('pages.emails.appointment_confirmation') // File Blade để render nội dung email
                    ->attach($this->appointment['qr_code_path'], [
                        'as' => 'qrcode.png',
                        'mime' => 'image/png',
                    ]);
    }
}

