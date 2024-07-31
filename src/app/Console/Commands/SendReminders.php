<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminder;
use App\Models\Reservation;
use App\Services\QrCodeService;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reservation reminders to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $reservations = Reservation::whereDate('date',$today)->with('user')->get();
        $qrCodeService = app(QrCodeService::class);

        foreach ($reservations as $reservation) {

        if ($reservation->user && $reservation->user->email) {
            Mail::to($reservation->user->email)->send(new ReservationReminder($reservation, $qrCodeService));
            }
        }
        $this->info('Reservation reminders sent successfully.');
    }
}
