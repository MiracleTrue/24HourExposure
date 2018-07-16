@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')


    <!--{{dump($user)}}-->


    <!--<a href="{{route('users.edit',$user->id)}}">修改资料</a>-->

	<div class="personlbox">
		<div class="header">
			<a href="javascript:history.go(-1)" class="goback"><</a>
			<span>个人中心</span>
		</div>
		<div class="personalinfo">
			<a style="border: none;" href="{{route('users.edit',$user->id)}}"><img src="{{$user->avatar_url}}" /></a>
			<p class="nickname">{{$user->name}}</p>
			<p class="name">{{$user->phone}}</p>
		</div>
		<p class="baoguang">
			<a href="my-exposure.php">我发布过的曝光 ></a>
			<a href="my-exposure.php">我评论过的曝光 ></a>
		</p>
		<p class="phone">客服电话：4008001818</p>
	</div>
	
	
@stop