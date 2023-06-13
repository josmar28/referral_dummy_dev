<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PregnantNotif implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $referring_facility;
    public $referring_facility_name;
    public $referring_md_name;
    public $referred_to_name;
    public $referred_to;
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$fac,$referring_md,$fac_to,$status)
    {   
        $this->referring_facility = $data['referring_facility'];
        $this->referring_facility_name = $fac->name;
        $this->referring_md_name = $referring_md->lname.', '.$referring_md->fname.' '.$referring_md->mname;
        $this->referred_to_name = $fac_to->name;
        $this->referred_to = $data['referred_to'];
        $this->status = $status;
    }

    public function broadcastAs()
    {
        return 'pregnant_event';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('pregnant_channel');
    }
}
