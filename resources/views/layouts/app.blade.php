<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '24小时曝光')</title>
    <!-- 样式 -->
    {{--<link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}
	<link rel="stylesheet" type="text/css" href="{{asset('web/css/reset.css')}}" />			
	<link rel="stylesheet/less" type="text/css" href="{{asset('web/less/login.less')}}">
	<link rel="stylesheet/less" type="text/css" href="{{asset('web/less/personl.less')}}">
	<link rel="stylesheet/less" type="text/css" href="{{asset('web/less/personl.less')}}">
	<script src="{{asset('web/js/jquery-1.8.3.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('web/js/rem.js')}}"></script>
	<script type="text/javascript" src="{{asset('web/js/less.min.js')}}"></script>
</head>
<body>
<div id="app" class="{{ route_class() }}-page">
        @yield('content')
</div>
<!-- JS 脚本 -->
{{--<script src="{{ mix('js/app.js') }}"></script>--}}

@yield('scriptsAfterJs')
</body>
</html>