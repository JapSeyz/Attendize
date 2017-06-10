<?php

namespace App\Models;

use App\Events\GuestCreated;
use App\Events\GuestStatusUpdated;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{

    protected $appends = [
        'checkin_date'
    ];


    public static function boot()
    {
        parent::boot();

        static::created(function ($guest) {
            event(new GuestCreated($guest));
        });

        static::updated(function ($guest) {
            if($guest->isDirty('has_arrived')) {
                event(new GuestStatusUpdated($guest));
            }
        });
    }




/**
     * Get the attendee checkIn Date
     *
     * @return string
     */
    public function getCheckinDateAttribute()
    {
        return $this->arrival_time ? $this->arrival_time->format('H:i d/m') : '';
    }
}
