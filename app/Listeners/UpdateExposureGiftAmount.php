<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

//  implements ShouldQueue 代表此监听器是异步执行的
class UpdateExposureGiftAmount implements ShouldQueue
{
    // Laravel 会默认执行监听器的 handle 方法，触发的事件会作为 handle 方法的参数
    public function handle(OrderPaid $event)
    {
        // 从事件对象中取出对应的订单
        $order = $event->getOrder();

        $order->exposure->update([
            'gift_amount' => bcadd($order->exposure->gift_amount, $order->total_amount, 2),
        ]);

    }
}
