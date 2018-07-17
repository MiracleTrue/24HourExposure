<?php

namespace App\Providers;

use App\Events\OrderPaid;
use App\Listeners\UpdateExposureGiftAmount;
use App\Listeners\UpdateUserGiftAmount;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [

        /*订单支付成功事件*/
        OrderPaid::class => [
            UpdateExposureGiftAmount::class,
            UpdateUserGiftAmount::class
        ],


    ];

    /**
     * Register any events for your application.
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
