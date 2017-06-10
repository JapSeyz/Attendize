<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Attendee;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendeeStatusUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $id;
    public $hasArrived;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Attendee $attendee
     */
    public function __construct(Attendee $attendee)
    {
        $this->id = (int) $attendee->id;
        $this->hasArrived = (bool) $attendee->has_arrived;
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
