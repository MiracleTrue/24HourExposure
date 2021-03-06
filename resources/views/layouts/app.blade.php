<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '24时刻')</title>
    <!-- 样式 -->
    {{--<link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('web/css/reset.css')}}"/>
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/login.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/personl.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/add.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/exposure-details.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/footer.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/header.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/home.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/my-exposure.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/news.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/newsshow.less')}}">
    <link rel="stylesheet/less" type="text/css" href="{{asset('web/less/search.less')}}">

    <link rel="stylesheet" href="{{asset('web/library/font-awesome-4.7.0/css/font-awesome.min.css')}}">

    <script type="text/javascript" src="{{asset('web/library/jquery/1.9.1/jquery.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('web/js/rem.js')}}"></script>
    <script type="text/javascript" src="{{asset('web/js/less.min.js')}}"></script>
</head>
<body>
<div id="app" class="{{ route_class() }}-page">
    @yield('content')
</div>
<!-- JS 脚本 -->
{{--<script src="{{ mix('js/app.js') }}"></script>--}}
<script>

    var oHeight = $(document).height(); //浏览器当前的高度
    $(window).resize(function () {
        if ($(document).height() < oHeight) {
            $("footer").css("position", "static");
        } else {
            $("footer").css("position", "absolute");
        }
    });

    /* 判断是否为微信 */
    function isWeiXin() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }

    /* $(function(){
        $('input').focus(function(){
        $('footer').css('display','none');
    })
    $('input').blur(function(){
        $('footer').css('display','block');
    })
    }) */
</script>
@yield('scriptsAfterJs')
</body>
</html>