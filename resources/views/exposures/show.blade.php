@extends('layouts.app')

@section('title',$exposure->title)
<style>
    .pay_method {
        width: 90%;
        font-size: 0.13rem;
        color: #333;
        background: #EEEEEE;
        position: absolute;
        top: 50%;
        left: 50%;
        padding: 10px 5px;
        border-radius: 25px;
        transform: translate(-50%, -50%);
    }

    .pay_method label {
        height: 1rem;
        border-bottom: 1px solid #f2f2f2;
        line-height: 0.7rem;
        display: flex;
        align-items: center;
        position: relative;
    }

    .pay_method label span {
        margin-left: 0.3rem;
        font-size: 0.25rem;
    }

    .pay_method label img:nth-of-type(1) {
        width: 0.6rem;
        height: 0.6rem;
        display: block;
        margin-left: 0.2rem;
    }

    input[type="radio"] {
        position: absolute;
        right: 10px;
        width: 0.3rem;
        height: 0.3rem;
    }

    input[type="button"] {

        width: 1.5rem;
        line-height: 0.5rem;
        height: 0.5rem;
        background: #d71f21;
        color: #FFFFFF;
        text-align: center;
        border: none;
        border-radius: 20px;
        display: block;
        margin-left: 20%;
    }

    /* input[type="checkbox"],
    input[type="radio"] {
        display: none;
    } */

    input[type="radio"] + i {
        border-radius: 7px;
    }

    input[type="checkbox"]:checked + i,
    input[type="radio"]:checked + i {
        background: #2489c5;
    }

    .pay_confirm {
        display: flex;
        align-content: center;
        justify-content: center;
    }

    .pay_confirm div {
        width: 1.5rem;
        line-height: 0.5rem;
        height: 0.5rem;
        background: #00aa6d;
        color: #FFFFFF;
        text-align: center;
        border: none;
        border-radius: 20px;
        display: block;
    }
</style>
@section('content')
    <form class="payform" action="{{route('payment.gift.alipay')}}" method="GET">
        {{csrf_field()}}

        <input type="hidden" name="exposure_id" value="{{$exposure->id}}">
        <input type="hidden" name="gifts" value=''>


    </form>



    <div class="exposurebox">
        <div class="header">
            <a href="{{route('root')}}"><</a>
            <span>曝光详情</span>
        </div>

        <!-- 支付方式选择 -->
        <div class="pay_method">
            <label style=""><img src="{{asset('web/img/alipay.png')}}"><span>支付宝支付</span> <input type="radio" name="pay_method" checked="checked"
                                                                                                 value="alipay"/></label>
            <label style=""><img src="{{asset('web/img/wechat.png')}}"><span>微信支付</span> <input type="radio" name="pay_method" value="wechat"/></label>
            <div class="pay_confirm">
                <div class="pay_cancel">取消</div>
                <input class="pay_submit" type="button" value="立即支付"/>
            </div>

        </div>


        <div class="comment">
            <span>{{$exposure->category->name}}</span>
            @foreach($exposure->gifts as $gift)

                <div class="pay" data-id="{{$gift->id}}" title="{{$gift->title}}"><img src="{{$gift->image_url}}">{{$gift->sum}}</div>
            @endforeach
        </div>
        <!--曝光对象-->
        <div class="exposure_object">
            <p class="date">{{$exposure->created_at}}</p>
            <div class="exposure_objecttitle">
                <img src="{{$exposure->user->avatar_url}}"/>
                <span class="name">{{$exposure->user->name}}</span>
                <span>曝光对象：<em>{{$exposure->name}}</em></span>
            </div>
            <div class="exposure_content">
                <p>
                    <span>标题:</span>
                    <span>{{$exposure->title}}</span>
                </p>
                <p>
                    <span>内容:</span>
                    <span>{{$exposure->content}}</span>
                </p>
            </div>

        </div>
        <!--评论内容-->
        <div class="comment_content">
            <h1>评论</h1>
            @foreach($comments as $key => $item)
                <div>
                    <p>{{++$key}}楼</p>
                    <div class="comment_personl">
                        <img src="{{$item->user->avatar_url}}"/>
                        <span class="name">{{$item->user->name}}</span>
                        <span>{{$item->created_at}}</span>
                    </div>
                    <p class="comment_show">
                        {{$item->content}}
                    </p>
                </div>
            @endforeach


        </div>
        <!--我的评论-->
        <div class="my_commert">

            <input class="mycomment_content" type="text" placeholder="写出你对他的评价"/>
            <input class="comments" type="submit" value="确认"/>

        </div>
    </div>
    <script type="text/javascript" src="{{asset('web/library/jqueryJson/jquery.json.js')}}"></script>
    <script>
        $(".pay_method").hide();
        $(".pay_cancel").click(function () {
            $(".pay_method").hide();
        })
        /* 判断是否为微信 */
        /* function isWeiXin(){
            var ua = window.navigator.userAgent.toLowerCase();
            if(ua.match(/MicroMessenger/i) == 'micromessenger'){
                $(".pay_method").find('p').eq(0).hide();
                return true;
            }else{
                $(".pay_method").find('p').eq(1).hide();
                return false;
            }
        } */
        // isWeiXin();


        $(".pay").each(function (i, index) {
            $(index).click(function () {

                if (isWeiXin()) {
                //     if (1) {

                    window.location.href = "{{route('payment.gift.wechat_mp')}}";

                } else {
                    $(".pay_method").show();
                    $(".pay_submit").on("click", function () {
                        var pay = $('input:radio[name="pay_method"]:checked').val();
                        /* alert(pay); */
                        if (pay == "alipay") {
                            var myJson = new Array();
                            var obj = new Object();

                            obj.id = $(index).attr('data-id');
                            obj.number = 1;
                            myJson.push(obj)
                            var strjson = $.toJSON(myJson);
                            console.log(strjson)
                            $("input[name='gifts']").val(strjson);
                            $('.payform').attr('action', '{{route("payment.gift.alipay")}}');
                            $('.payform').submit();

                        } else {
                            var myJson = new Array();
                            var obj = new Object();

                            obj.id = $(index).attr('data-id');
                            obj.number = 1;
                            myJson.push(obj)
                            var strjson = $.toJSON(myJson);
                            console.log(strjson)
                            $("input[name='gifts']").val(strjson);

                            $('.payform').attr('action', '{{route("payment.gift.wechat_h5")}}');
                            $('.payform').submit();
                        }
                    });
                }


            });
        });


        $('.comments').click(function () {
            var id ={{$exposure->id}};
            $.ajax({
                url: '{{ route("exposure_comments.store") }}',
                type: "post",
                data: {
                    content: $('.mycomment_content').val(),
                    exposure_id: id,
                    _token: '{{csrf_token()}}'

                },

                success: function (res) {
                    console.log(res);
                    alert("评论成功");
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error);
                    console.log(error.status)
                    if (error.status == 422) {
                        alert('评论内容不能为空');
                    }
                    if (error.status == 401) {
                        window.location.href = "{{route('login')}}"
                    }
                }
            })
        })
    </script>

@stop