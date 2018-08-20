@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')


	<div class="personlbox">
		<div class="header">
			
			<a href="javascript:history.go(-1)" class="goback"></a>
			<span>个人中心</span>

		
		</div>
		<div class="personalinfo">
			<a style="border: none;" href="{{route('users.edit',$user->id)}}"><img src="{{$user->avatar_url}}" /></a>
			<p class="nickname">{{$user->name}}</p>
			<p class="name">{{$user->phone}}</p>
		</div>
		<p class="baoguang">
			<a href="{{route('users.released_exposures')}}">我发布过的对象 ></a>
			<a href="{{route('users.commented_exposures')}}">我评论过的对象 ></a>
		</p>
		{{--<p class="phone">客服电话：4008001818</p>--}}
	</div>
	
	@include('layouts._footer')
@stop