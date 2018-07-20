<?php

namespace App\Http\Middleware;

use App\Models\Location;
use Closure;
use GuzzleHttp\Client;

/**
 * 位置服务
 * Class LBS
 * @package App\Http\Middleware
 */
class LBS
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle($request, Closure $next)
    {
        
        if (!$request->session()->has('LBS'))
        {
            $client = new Client();

            $res = $client->request('GET', 'https://apis.map.qq.com/ws/location/v1/ip', [
                'query' => [
                    'ip' => $request->getClientIp(),
                    'key' => config('app.tencent_lbs_key'),
                ],
            ]);

            $res = json_decode($res->getBody()->getContents(), true);

            if ($res['status'] == 0 && !empty($res['result']['ad_info']['city']))
            {
                if ($location = Location::where('city', $res['result']['ad_info']['city'])->first())
                {
                    $request->session()->put('LBS', $location);
                } else
                {
                    $location = Location::create([
                        'nation' => $res['result']['ad_info']['nation'],
                        'province' => $res['result']['ad_info']['province'],
                        'city' => $res['result']['ad_info']['city']
                    ]);
                    $request->session()->put('LBS', $location);
                }

            } else
            {
                $request->session()->put('LBS', Location::where('city', '青岛市')->first());
            }
        }


        return $next($request);
    }
}
