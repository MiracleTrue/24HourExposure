@extends('layouts.app')

@section('title',' 的个人中心')

@section('content')
  {{dump($exposure)}}
    {{dump($comments)}}

<div class="exposurebox">
	<div class="header">
		<a href="javascript:history.go(-1)"><</a>
		<span>曝光详情</span>
	</div>
	<div class="comment">
		<span>餐饮</span>
		<div>56</div>
		<div>56</div>
		<div>56</div>
		<div>56</div>
		<div>56</div>		
	</div>
	<!--曝光对象-->
	<div class="exposure_object">
		<p class="date">2018-03-22</p>
		<div class="exposure_objecttitle">
			<img src="{{$exposure->user->avatar}}" />
			<span class="name">{{$exposure->name}}</span>
			<span>曝光对象：<em>{{$exposure->title}}</em></span>
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
			@foreach($comments as $item)
				<div>
					<p>1楼</p>
					<div class="comment_personl">
						<img src="{{$item->user->avatar}}" />
						<span class="name"></span>
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
			
				<input class="mycomment_content" type="text"placeholder="写出你对他的评价" />
				<input class="comments" type="submit" value="确认"/>
			
		</div>
</div>
	<script>
		 $('.comments').click(function(){
			 var id={{$exposure->id}};
			$.ajax({
				url: '{{ route("exposure_comments.store") }}',
				type:"post",
				data:{
					content:$('.mycomment_content').val(),
					exposure_id:id,
					_token:'{{csrf_token()}}'
					
				},
				
				success: function(res) {
					console.log(res);
					alert("评论成功");
				},
				error:function(error)
				{
					console.log(error);

				}
			})
		}) 
	</script>
	
@stop