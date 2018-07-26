@extends('layouts.app')

@section('title',$exposure->title)

@section('content')
		<form class="payform" action="{{route('payment.gift.alipay')}}" method="GET">
			{{csrf_field()}}

		<input type="hidden" name="exposure_id" value="{{$exposure->id}}">
		<input type="hidden" name="gifts" value=''>

		
	</form>
	
	
	<div class="header exposureboxheader">
		<a href="{{route('root')}}"><</a>
		<span>曝光详情</span>
	</div>
<div class="exposurebox">
	
	<div
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
			<img src="{{$exposure->user->avatar_url}}" />
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
						<img src="{{$item->user->avatar_url}}" />
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
			
				<input class="mycomment_content" type="text"placeholder="写出你对他的评价" />
				<input class="comments" type="submit" value="确认"/>
			
		</div>
</div>
<script type="text/javascript" src="{{asset('web/library/jqueryJson/jquery.json.js')}}"></script>
	<script>
		$(".pay").each(function(i,index){
			$(index).click(function(){
				var myJson=new Array();
				var obj=new Object();

				obj.id=$(index).attr('data-id');

				obj.number=1;

				
				myJson.push(obj)
				
				
				var strjson = $.toJSON(myJson);
				console.log(strjson)
				$("input[name='gifts']").val(strjson);
				
				  $('.payform').submit();  
			})
		})
		
		
		
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
					window.location.reload();
				},
				error:function(error)
				{
					console.log(error);
					console.log(error.status)
						if(error.status==422){
							alert('评论内容不能为空');
						}
						if(error.status==401){
							window.location.href="{{route('login')}}"
						}
				}
			})
		}) 
	</script>
	
@stop