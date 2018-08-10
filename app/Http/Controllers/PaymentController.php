<?php

namespace App\Http\Controllers;

use App\Events\OrderPaid;
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

    public static function alipayConfig($config = null)
    {

        if (is_array($config))
        {
            $final_config = array_merge(array_merge(config('pay.alipay'), [
                'notify_url' => route('payment.gift.alipay_notify'),
                'return_url' => url()->previous(),
            ]), $config);
        } else
        {
            $final_config = array_merge(config('pay.alipay'), [
                'notify_url' => route('payment.gift.alipay_notify'),
                'return_url' => url()->previous(),
            ]);
        }

        return $final_config;
    }

    public static function wechatConfig($config = null)
    {

        if (is_array($config))
        {
            $final_config = array_merge(array_merge(config('pay.wechat'), [
                'notify_url' => route('payment.gift.wechat_notify'),
                'return_url' => url()->previous(),
            ]), $config);
        } else
        {
            $final_config = array_merge(config('pay.wechat'), [
                'notify_url' => route('payment.gift.wechat_notify'),
                'return_url' => url()->previous(),
            ]);
        }

        return $final_config;
    }

    /**
     * @param GiftByAlipayRequest $request
     * @return \Yansongda\Pay\Gateways\Wechat\WapGateway
     * @throws \Throwable
     */
    public function giftByWechat(GiftByAlipayRequest $request)
    {
        $user = $request->user();
        $exposure = Exposure::find($request->input('exposure_id'));
        // 开启一个数据库事务
        $order = DB::transaction(function () use ($user, $request, $exposure) {

            // 创建一个订单
            $order = new Order([
                'payment_method' => Order::PAYMENT_METHOD_WECHAT,
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

        return Pay::wechat(self::wechatConfig([
                'return_url' => route('exposures.show', $exposure->id),
            ]
        ))->wap([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_fee' => bcmul($order->total_amount, 100, 2), // **单位：分**
            'body' => '支付 24HourExposure  礼物的订单：' . $order->no, // 订单标题
//            'openid' => $request->input('openid'),
        ]);

    }

    public function giftWechatNotify(Request $request)
    {
//        // 校验输入参数
//        $data = Pay::alipay(self::alipayConfig())->verify();
//
//        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
//        $order = Order::where('no', $data->out_trade_no)->where('closed', false)->first();
//        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
//        if (!$order)
//        {
//            return 'fail';
//        }
//        // 如果这笔订单的状态已经是已支付
//        if ($order->paid_at)
//        {
//            return Pay::alipay($this->alipayConfig())->success();
//        }
//
//        $order->update([
//            'paid_at' => now(), // 支付时间
//            'payment_method' => Order::PAYMENT_METHOD_ALIPAY, // 支付方式
//            'payment_no' => $data->trade_no, // 支付宝订单号
//        ]);
//
//        event(new OrderPaid($order));
//
//        return Pay::alipay($this->alipayConfig())->success();
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

        return Pay::alipay(self::alipayConfig([
                'return_url' => route('exposures.show', $exposure->id),
            ]
        ))->wap([
            'out_trade_no' => $order->no, // 订单编号，需保证在商户端不重复
            'total_amount' => $order->total_amount, // 订单金额，单位元，支持小数点后两位
            'subject' => '支付 24HourExposure  礼物的订单：' . $order->no, // 订单标题
        ]);
    }


    /**
     * @param Request $request
     * @return string|\Symfony\Component\HttpFoundation\Response
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     */
    public function giftAlipayNotify(Request $request)
    {
        // 校验输入参数
        $data = Pay::alipay(self::alipayConfig())->verify();

        // $data->out_trade_no 拿到订单流水号，并在数据库中查询
        $order = Order::where('no', $data->out_trade_no)->where('closed', false)->first();
        // 正常来说不太可能出现支付了一笔不存在的订单，这个判断只是加强系统健壮性。
        if (!$order)
        {
            return 'fail';
        }
        // 如果这笔订单的状态已经是已支付
        if ($order->paid_at)
        {
            return Pay::alipay($this->alipayConfig())->success();
        }

        $order->update([
            'paid_at' => now(), // 支付时间
            'payment_method' => Order::PAYMENT_METHOD_ALIPAY, // 支付方式
            'payment_no' => $data->trade_no, // 支付宝订单号
        ]);

        event(new OrderPaid($order));

        return Pay::alipay($this->alipayConfig())->success();
    }

}
