@extends('layouts.app')

@section('content')
<style>

.selcct >div {
	display: flex;
	justify-content: center;
}
</style>


 
<div class="newsbox">
	<div class="header">
		<span>资讯中心</span>
		<a href="javascript:history.go(-1)"></a>
	</div>
	<div class="news_serach">
		<div>
			<form class="myselcct" action="{{route('news.index')}}" method="get">
				<input type="text" name="search" placeholder="请输入标题查询对应文章" />
				<input type="submit" value="搜索" />
		
		</div>
			<div>
				<div><span>分类：</span>
				
				<select name="category" class="categories">
					<option value="">全部</option>
					@foreach($categories as $item)
					
					<option value="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				</select></div>
				<div><span>时间：</span>
				<select name="time" class="selcct_time">
					<option value="">请选择</option>
					<option value="7_days">最近7天</option>
					<option value="last_month">最近一个月</option>
					<option value="half_year">最近半年</option>
				</select>
				</div>
			</div>
		</form>
	</div>
	<!--newslist-->
	<ul class="news_list">
		@foreach($news as $item)
		<li>
			<a href="{{route('news.show',$item->id)}}">
				<span class="category">{{$item->category->name}}</span>
				<img src="{{$item->image_url}}" />
				<p>{{$item->title}}</p>
				<span class="date">{{$item->created_at}}</span>
			</a>
		</li>
		@endforeach

	
	</ul>
	{{ $news->appends($filters)->render() }}
	<!--page-->
	<!--<div class="page">
		<div>
			<a class="pageselect">上一页</a>
			<a class="active">1</a>
			<a>2</a>
			<a class="pageselect">下一页</a>
			<a class="pageselect">末页</a>
		</div>
	</div>-->
</div>
@include('layouts._footer')
	<script src="{{asset('web/library/jquery.form/jquery.form.js')}}"></script>
	<script>
		var filters = {!! json_encode($filters) !!};
		
		console.log(filters)
		
		$(document).ready(function () {
			$('.categories').val(filters.category);
			$('.selcct_time').val(filters.time);
			$("input[name='search']").val(filters.search);
		});

	/* 	$('.search-form select[name=order]').on('change', function () {
			$('.search-form').submit();
		}); */
		
		
		$(".categories").change(function(){
			$(".myselcct").trigger('submit')
		})
		$(".selcct_time").change(function(){
			$(".myselcct").trigger('submit')
		})
	</script>

@stop