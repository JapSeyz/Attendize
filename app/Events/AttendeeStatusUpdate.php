<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Attendee;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendeeStatusUpdate extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $id;
    public $hasArrived;
    public $arrivalTime;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Attendee $attendee
     */
    public function __construct(Attendee $attendee)
    {
        $this->id = $attendee->id;
        $this->hasArrived = $attendee->has_arrived;
        $this->arrivalTime = $attendee->arrival_time;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['musikliv'];
    }

    public function broadcastAs(){
        return 'attendee-status';
    }
}
