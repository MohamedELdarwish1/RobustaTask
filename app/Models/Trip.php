<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'start_station_id',
        'end_station_id',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }
    public function usersTrips()
{
    return $this->hasMany(UserTrip::class);
}
}
