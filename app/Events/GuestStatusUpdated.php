<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GuestStatusUpdated extends Event
{
    use SerializesModels;

    public $id;
    public $hasArrived;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Attendee $attendee
     */
    public function __construct(Guest $guest)
    {
        $this->id = (int) $guest->id;
        $this->hasArrived = (bool) $guest->has_arrived;
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
        return 'guest-status';
    }
}
