<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

//  implements ShouldQueue 代表此监听器是异步执行的
class UpdateUserGiftAmount implements ShouldQueue
{

    public function handle(OrderPaid $event)
    {
        // 从事件对象中取出对应的订单
        $order = $event->getOrder();

        $order->user->update([
            'gift_amount' => bcadd($order->user->gift_amount, $order->total_amount, 2),
        ]);
    }

}
