@extends('layouts.app')

@section('title', 'XXX')

@section('content')



 <!--  {{dump($categories)}}
    {{dump($exposures)}}
   {{dump($lbs)}}
-->
<!--{{dump($today_news)}}-->
    @include('common.error')

<header><span>曝光台</span> <a href="../add-exposure.php"></a></header>
<div class="homebox">
	<div class="location">
		<!--定位-->
		<div>
			<a href="{{ route('locations.relocation') }}" id="position">{{$lbs->city}}</a>
		</div>
		<div>
			<form class="myselcct" action="{{route('exposures.index')}}" method="get">	
				<input type="text" name="search" placeholder="请输入曝光对象精确查找" />
				<input type="submit" value="确定" />

		</div>
		
	</div>

	<!--<form action="{{route('payment.gift.alipay')}}" method="POST">
		{{csrf_field()}}

		<input type="hidden" name="exposure_id" value="8">
		<input type="hidden" name="gifts" value='[{"id":1,"number":1}]'>

		<input type="submit" value="支付">
	</form>-->
	<!--分类-->
	<div class="classification">
		<span>分类：</span>
		<div>
			<select name="category" class="categories">
				<option value="">全部</option>
				@foreach($categories as $item)
					<option value="{{$item->id}}">{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<span>筛选：</span>
		<div>
			<select name="sort" class="sort">
				<option value="">请选择</option>
				<option value="created_time_desc">时间由先到后</option>
				<option value="created_time_asc">时间由后到先</option>
				<option value="gift_amount_more">礼物金额由多到少</option>
				<option value="gift_amount_less">礼物金额由少到多</option>
			</select>
		</div>
		</form>

	</div>
	<!--曝光列表-->
	<ul class="exposure_list">
		
		@foreach($exposures as $item)

		<li>
			<a href="{{route('exposures.show',$item->id)}}">
			<div></div>
			<div><img src="{{asset('web/img/baoguanglist.png')}}"/></div>
			<div>
				<div class="title">
					<span>{{$item->category->name}}</span>
					<span>曝光对象：</span>
					<span>{{$item->name}}</span>
				</div>
				<div class="comment">
					

					@foreach($item->gifts as $gift)
					

						<div title="{{$gift->title}}"><img style="" src="{{$gift->image_url}}">{{$gift->sum}}</div>
					@endforeach
					
				</div>
			</div>
			</a>
		</li>
		@endforeach
	</ul>
	<!--今日资讯-->
	<div class="todynews">
		<div></div>
		@foreach($today_news as $item)
			<a href="{{route('news.show',$item->id)}}"><span style="margin-right: 10px;">今日资讯</span><span>{{$item->content}}</span></a>
		@endforeach
	
	</div>
	
	{{ $exposures->appends($filters)->render() }}
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
<!--<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script>
	var geolocation = new qq.maps.Geolocation("OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77", "myapp");
	geolocation.getLocation(showPosition)
	function showPosition(position) {
		document.getElementById("position").innerHTML = position.city
	};
</script>-->
<script>
	var filters = {!! json_encode($filters) !!};
		console.log(filters);
		$(document).ready(function () {
			$('.categories').val(filters.category);
			$('.sort').val(filters.sort);
		});
	$(".categories").change(function(){
		$(".myselcct").trigger('submit');
	})
	$(".sort").change(function(){
		$(".myselcct").trigger('submit');
	})
</script>

@stop