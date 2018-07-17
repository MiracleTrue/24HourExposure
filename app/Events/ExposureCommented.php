<?php

namespace App\Events;

use App\Models\ExposureComment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExposureCommented
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $exposure_comment;


    public function __construct(ExposureComment $exposureComment)
    {
        $this->exposure_comment = $exposureComment;
    }

    public function getComment()
    {
        return $this->exposure_comment;
    }

}
