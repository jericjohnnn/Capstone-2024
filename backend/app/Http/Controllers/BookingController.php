<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingRequest;
use App\Models\Booking;
use App\Models\BookingDate;
use App\Models\BookingMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function createBooking(BookingRequest $request)
    {
        $validatedData = $request->validated();

        $booking = Booking::create($validatedData);

        $bookingMessage = BookingMessage::create([
            'booking_id' => $booking->id,
            'title' => $validatedData['message_title'],
            'message' => $validatedData['message_content'],
        ]);

        foreach ($validatedData['selected_date_times'] as $dateTime) {
            BookingDate::create([
                'booking_message_id' => $bookingMessage->id,
                'start_time' => $dateTime['start'],
                'end_time' => $dateTime['end'],
            ]);
        }

        return response()->json([
            'message' => 'Booking requested successfully.',
        ]);
    }
}
