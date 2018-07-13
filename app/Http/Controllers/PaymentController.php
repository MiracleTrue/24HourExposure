<?php

namespace App\Http\Controllers;

use App\Http\Requests\GiftByAlipayRequest;
use App\Jobs\CloseOrder;
use App\Models\Exposure;
use App\Models\Gift;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yansongda\Pay\Pay;

class PaymentController extends Controller
{

    public static function alipayConfig()
    {
        return array_merge(config('pay.alipay'), [
            'notify_url' => route('payment.gift.alipay_notify'),
            'return_url' => url()->previous(),
        ]);
    }

    /**
     * @param GiftByAlipayRequest $request
     * @return mixed
     * @throws \Throwable
     */
    public function giftByAlipay(GiftByAlipayRequest $request)
    {

        $user = $request->user();
        $exposure = Exposure::find($request->input('exposure_id'));
        // 开启一个数据库事务
        $order = DB::transaction(function () use ($user, $request, $exposure) {

            // 创建一个订单
            $order = new Order([
                'payment_method' => Order::PAYMENT_METHOD_ALIPAY,
                'closed' => false,
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            $order->exposure()->associate($exposure);
            // 写入数据库
            $order->save();

            $totalAmount = 0;
            $items = json_decode($request->input('gifts'), true);


            // 遍历用户提交的 SKU
            foreach ($items as $data)
            {
                $gift = Gift::find($data['id']);

                $item = $order->items()->make(
                    [
                        'number' => $data['number'],
                        'item_price' => bcmul($gift->price, $data['number'], 2),
                    ]);

                $item->order()->associate($order);
                $item->gift()->associate($gift);
                $item->save();

                $totalAmount = bcadd($totalAmount, $item->item_price, 2);
            }


            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            return $order;
        });
        $this->dispatch(new CloseOrder($order, config('app.order_ttl')));

        return Pay::alipay(self::alipayConfig())->web([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject' => '支付 24HourExposure  礼物的订单：' . $order->no, // 订单标题
        ]);
    }


    public function giftAlipayNotify(Request $request)
    {
        Log::error($request->all());

        
    }

}
