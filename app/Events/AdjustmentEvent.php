<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdjustmentEvent
{
    public $adjustment;
    public $method;
    public $original;

    public function __construct($adjustment, $method = 'created', $original = null)
    {
        $this->method = $method;
        $this->original = $original;
        $this->adjustment = $adjustment;
    }
}
