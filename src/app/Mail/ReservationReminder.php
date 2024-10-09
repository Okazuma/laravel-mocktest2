<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Services\QrCodeService;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation,QrCodeService $qrCodeService)
    {
        //
        $this->reservation = $reservation;
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $data = route('management.reservations');
        $qrCode = $this->qrCodeService->generateQrCode($data);
        $paymentUrl = url('/checkout');

        return $this->view('email.email-reminder')
                    ->with([
                        'reservation' => $this->reservation,
                        'paymentUrl' => $paymentUrl,
                    ])
                    ->attachData(base64_decode(substr($qrCode, strpos($qrCode, ',') + 1)), 'qrcode.png', [
                        'mime' => 'image/png',
                        'as' => 'qrcode.png',
                    ]);
    }
}