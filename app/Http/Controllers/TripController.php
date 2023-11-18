<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailableSeatsRequest;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\UsersTrip;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function index(Request $request)
    {
        //list all trips
        $trips = Trip::with(['bus', 'seats', 'startStation', 'endStation'])->get();
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => ['All Trips' =>  TripResource::collection($trips)],
        ]);
    }

    public function availableSeats(AvailableSeatsRequest $request)
    {
        $request->validated();

        try {
            $startStationId = $request->start_station_id;
            $endStationId = $request->end_station_id;

            $trips = Trip::where('start_station_id', $startStationId)
                ->where('end_station_id', $endStationId)
                ->get();

            $availableSeats = [];

            foreach ($trips as $trip) {
                $availableSeats[$trip->id] = $trip->seats()->where('is_booked', false)->pluck('seat_number');
            }

            return response()->json([
                'status' => true,
                'message' => null,
                'data' => ['available_seats' => $availableSeats],
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Failed',
                'errors' => $e->getMessage(),
            ]);
        }
    }

    public function bookSeat(Request $request)
    {

        $trip = Trip::find($request->tripId);

        // Check if the seat exists for the specified trip
        $seat = $trip->seats()->where('seat_number', $request->seatNumber)->first();

        if ($seat && !$seat->is_booked) {
            // Book the seat
            $seat->is_booked = true;
            $seat->save();
            UsersTrip::firstOrCreate([
                'user_id' => $request->user()->id,
                'trip_id' => $trip->id,
                'seat_number' => $seat->seat_number
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Seat booked successfully',
                'data' => ['seat' => $seat],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Seat not available or already reserved',
                'data' => [],
            ], 422);
        }
    }
}
