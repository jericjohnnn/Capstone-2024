<?php

use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/test/{test_id}', [BookingController::class, '']);
    Route::get('/test', [BookingController::class, '']);

    Route::post('/create-booking', [BookingController::class, 'createBooking']);

    Route::patch('/test/{test_id}', [BookingController::class, '']);

    Route::delete('/test/{test}', [BookingController::class, '']);
});
Route::get('/bookings/{bookingId}/details', [BookingController::class, 'showBookingDetails']);
Route::get('/bookings/all-bookings', [BookingController::class, 'showAllBookings']);

