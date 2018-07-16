@extends('layouts.app')

@section('title', 'XXX')

@section('content')



  <!--  {{dump($categories)}}
    {{dump($exposures)}}
   {{dump($lbs)}}-->

    @include('common.error')
    <!--<form action="{{route('payment.gift.alipay')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" name="exposure_id" value="8">
        <input type="hidden" name="gifts" value='[{"id":1,"number":1},{"id":7,"number":2}]'>

        <input type="submit" value="OK">
    </form>-->
<header><span>曝光台</span> <a href="../add-exposure.php"></a></header>
<div class="homebox">
	<div class="location">
		<!--定位-->
		<div>
			<span id="position">{{$lbs->city}}</span>
		</div>
		<div>
			<form>	
				<input type="text" placeholder="请输入曝光对象精确查找" />
				<input type="submit" value="确定" />
			</form>
		</div>
		
	</div>
	<!--分类-->
	<div class="classification">
		<span>分类：</span>
		<div>
			<select>
				
				<option>全部</option>
				@foreach($categories as $item)
					<option>{{$item->name}}</option>
				@endforeach
			</select>
		</div>
		<span>筛选：</span>
		<div>
			<select>
				<option>时间由先到后</option>
				<option>时间由后到先</option>
				<option>礼物金额由多到少</option>
				<option>礼物金额由少到多</option>
			</select>
		</div>
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
					<span>餐饮</span>
					<span>曝光对象：</span>
					<span>{{$item->title}}</span>
				</div>
				<div class="comment">
					<div>56</div>
					<div>56</div>
					<div>56</div>
					<div>56</div>
					<div>56</div>
					
				</div>
			</div>
			</a>
		</li>
		@endforeach
	</ul>
	<!--今日资讯-->
	<div class="todynews">
		<div></div>
		<a href=""><span>今日资讯一</span><span>黄焖鸡怎么做才入味</span></a>
		<a href=""><span>今日资讯二</span><span>黄焖鸡怎么做才入味</span></a>
	</div>
	<!--page-->
	<div class="page">
		<div>
			<a class="pageselect">上一页</a>
			<a class="active">1</a>
			<a>2</a>
			<a class="pageselect">下一页</a>
			<a class="pageselect">末页</a>
		</div>
	</div>
</div>
<!--<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
<script>
	var geolocation = new qq.maps.Geolocation("OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77", "myapp");
	geolocation.getLocation(showPosition)
	function showPosition(position) {
		document.getElementById("position").innerHTML = position.city
	};
</script>-->
	
	

@stop