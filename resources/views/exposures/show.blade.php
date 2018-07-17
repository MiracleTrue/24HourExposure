@extends('layouts.app')

@section('title',' 的个人中心')

@section('content')
{{dump($exposure)}}
    {{dump($comments)}}

		
		<form class="payform" action="{{route('payment.gift.alipay')}}" method="POST">
			{{csrf_field()}}

		<input type="hidden" name="exposure_id" value="">
		<input type="hidden" name="gifts" value='[{"id":1,"number":1}]'>

		<input type="submit" value="支付">
	</form>
	
	
	
<div class="exposurebox">
	<div class="header">
		<a href="javascript:history.go(-1)"><</a>
		<span>曝光详情</span>
	</div>
	<div class="comment">
	<span>{{$exposure->category->name}}</span>
		@foreach($exposure->gifts as $gift)
						

		<div class="pay" exposure_id="{{$gift->id}}" title="{{$gift->title}}"><img  src="{{$gift->image_url}}">{{$gift->sum}}</div>
	@endforeach
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

				obj.id=$(index).attr('exposure_id');

				obj.number=1;

				
				myJson.push(obj)
				
				
				var strjson = $.toJSON(myJson);
			
				
				
				$("input[name='exposure_id']").val($(index).attr("exposure_id"));
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
				},
				error:function(error)
				{
					console.log(error);

				}
			})
		}) 
	</script>
	
@stop