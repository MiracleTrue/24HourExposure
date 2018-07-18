@extends('layouts.app')

@section('title',' 的个人中心')

@section('content')
  <!--  {{dump($news)}}-->

<div class="newsshowbox">
	<div class="header">
		<a href="javascript:history.go(-1)" class="goback"><</a>
		<span>资讯详情</span>	
	</div>
	<div class="newscomment">
		<h1>
			<span>{{$news->category->name}}</span>
			<span>{{$news->title}}</span>
		</h1>
		<p class="date">{{$news->created_at}}</p>
		
		<p class="newsdetails">
			{{$news->content}}
		</p>
	</div>
	
	
	
	
	
</div>
@stop