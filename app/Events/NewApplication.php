<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewApplication implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function broadcastOn()
    {
        return new Channel('marshall-notifications');
    }

    public function broadcastAs()
    {
        return 'new.application';
    }
}
