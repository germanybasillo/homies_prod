<?php
// app/Console/Commands/NotifyDueDate.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingMessage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BookingDueDateNotification;

class NotifyDueDate extends Command
{
    protected $signature = 'bookingmessage:notify_due_date';
    protected $description = 'Send notifications for booking messages with due dates close to today';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = now()->toDateString();
        $bookingMessages = BookingMessage::where('due_date', '=', $today)
                                          ->where('status', 'pending') // Add any status filter if required
                                          ->get();

        foreach ($bookingMessages as $bookingMessage) {
            // Send the notification to the receiver of the booking message
            Notification::send($bookingMessage->receiver, new BookingDueDateNotification($bookingMessage));
            $this->info("Notification sent for Booking Message ID: {$bookingMessage->id}");
        }
    }
}

