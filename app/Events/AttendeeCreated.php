<?php

namespace App\Events;

use App\Events\Event;
use App\Models\Attendee;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendeeCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $attendee;
    /**
     * Create a new event instance.
     *
     * @param \App\Models\Attendee $attendee
     */
    public function __construct(Attendee $attendee)
    {
        $attendee->ticket = $attendee->ticket->title;
        $this->attendee = $attendee;
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
        return 'attendee-created';
    }
}
