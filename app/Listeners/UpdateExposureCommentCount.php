<?php

namespace App\Listeners;

use App\Events\ExposureCommented;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateExposureCommentCount implements ShouldQueue
{

    /**
     * Handle the event.
     * @param  ExposureCommented $event
     * @return void
     */
    public function handle(ExposureCommented $event)
    {
        $comment = $event->getComment();


        $comment->exposure->increment('comment_count');
    }
}
