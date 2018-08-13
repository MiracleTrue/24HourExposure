@extends('layouts.app')

@section('title','')
<style>
	.pay_method {
		z-index: 100;
		width: 90%;
		font-size: 0.13rem;
		color: #333;
		background: #EEEEEE;
		position: absolute;
		top: 50%;
		left: 50%;
		padding: 10px 5px;
		border-radius: 25px;
		 transform: translate(-50%,-50%);
		 display: none;
	}
 .pay_method label {
    height: 1rem;
    border-bottom: 1px solid #f2f2f2; 
    line-height: 0.7rem;
    display: flex;
		align-items: center;
		position: relative;
}
 .pay_method label span{
	 margin-left: 0.3rem;
	 font-size: 0.25rem;
 }
 .pay_method label img:nth-of-type(1) {
    width: 0.6rem;
    height: 0.6rem;
    display: block;
		margin-left: 0.2rem;
}
input[type="radio"]{
 position: absolute;
 right: 10px;
 width: 0.3rem;
 height: 0.3rem;
}
input[type="button"]{
	
	    width: 1.5rem;
    line-height: 0.5rem;
    height: 0.5rem;
    background: #d71f21;
    color: #FFFFFF;
    text-align: center;
    border: none;
    border-radius: 20px;
		display: block;
		margin-left: 20%;
}

/* input[type="checkbox"],
input[type="radio"] {
	display: none;
} */
 
input[type="radio"]+ i {
	border-radius: 7px;
}
 
input[type="checkbox"]:checked+ i,
input[type="radio"]:checked+ i {
	background: #2489c5;
}

.pay_confirm{
	display: flex;
	align-content: center;
	justify-content: center;
}
	.pay_confirm div{
		width: 1.5rem;
		line-height: 0.5rem;
		height: 0.5rem;
		background: #00aa6d;
		color: #FFFFFF;
		text-align: center;
		border: none;
		border-radius: 20px;
		display: block;
	}
</style>
@section('content')
 
	<div class="addbox">
		<div class="header">
			<a href="{{route('root')}}" class="goback"><</a>
			<span>增加曝光</span>
			
		</div>
		<div class="pay_method">
			<label style=""><img src="{{asset('web/img/alipay.png')}}"><span>支付宝支付</span> <input type="radio" name="payto_method" checked="checked" value="alipay" /></label>
			<label style=""><img src="{{asset('web/img/wechat.png')}}"><span>微信支付</span> <input type="radio" name="payto_method"  value="wechat" /></label>
			<div class="pay_confirm">
				<div class="pay_cancel">取消</div>
				<input class="pay_submit" type="button" value="立即支付" />
			</div>
			
		</div>
		@include('common.error')
		<form id="create" class="create" action="{{ route('exposures.store') }}" method="post">
			{{ csrf_field() }}
			<div>
			<p>
				<span>选择分类：</span>
				<select name="category_id">
					<option value="">全部</option> 
					@foreach($categories as $item)
						<option  @if($item->id == old("category_id")) selected="selected" @endif value="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				</select>
			</p>
			<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>曝光对象：</span>
					<input name="name" type="" placeholder="" value="{{ old('name') }}"  />
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>标题：</span>
					<input name="title" type="text" placeholder="请输入要曝光的对象" value="{{ old('title') }}" />
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p class="content">
					<span>内容：</span>
					<textarea name="content" >{{ old('content') }}</textarea>
				</p>
				<span class="tipinfo"></span>
			</div>
			<input type="hidden" name="gifts" value=''>
			<div class="comment">
				
				@foreach($gifts as $item)
					<div style="display: flex;"  title="{{$item->title}}"><img style="" src="{{$item->image_url}}"><input data_id="{{$item->id}}" style="width: 0.4rem;border: 1px solid #999999;height: 0.57rem;text-align: center;" type="number" min="0" value="0"/> <p class="gift_num"><span class="add" >+</span><span class="reduce">-</span></p>               </div>
				@endforeach	
			</div>
			<input class="nextstep" type="submit" value="提交" />
			
			<input type="hidden" name="pay_method" value=""/>
		</form>
	</div>
    
  <script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
	 <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>-->
   <script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/validate-methods.js')}}"></script>
	 <script type="text/javascript" src="{{asset('web/library/jqueryJson/jquery.json.js')}}"></script>

	<script>
		$(".pay_method").hide();
$(".pay_cancel").click(function(){
			$(".pay_method").hide();
		})
		$(function(){	
				$(".add").on("click",function(){
				var val =	$(this).parent().siblings('input').val();
				val++
					
				$(this).parent().siblings('input').val(val)
				})
				$(".reduce").on("click",function(){
				var val =	$(this).parent().siblings('input').val();
				if(val>0){
					val--
				}
				
					
				$(this).parent().siblings('input').val(val)
				})
		
		
		
		
		
		
		 	var strjson="";
					/* $('.nextstep').click(function(){ 
						var myJson=new Array();
						$(".comment input").each(function(i,index){
							var obj=new Object();
							obj.id=$(index).attr('data_id');
							obj.number=$(index).val();
							if(obj.number!=0){
								myJson.push(obj);
							}
							
						})
						
						strjson = $.toJSON(myJson);
						console.log(strjson)
						if(strjson=='[]'){
							$("input[name='gifts']").attr("name","");
						}else{
							$(".pay_method").show();
							var pay=$('input:radio[name="pay_method"]:checked').val();
							$("input[name='pay_method']").val(pay);
							$("input[name='gifts']").val(strjson);
						}
						
				}) 
			 */
		
		
	  $("#create").validate({
				rules: {
					category:{
						required:true,
						
					},
					name: {
						required: true,
					},
					title:{
						required: true
					},
					content:{
						required:true,
						
					}
						
				},
				messages: {
					category: {
						required: "请选择分类"
					},
					name:{
						required: "请输入曝光对象",
					},
					title:{
						required:'请输入标题',
						
					},
					content:{
						required:"请输入曝光的内容",
						
					}
				},
				errorPlacement: function(error, element) {                             //错误信息位置设置方法
				error.appendTo( element.parent().parent().find(".tipinfo"));           //这里的element是录入数据的对象
				},
				submitHandler: function(form) {
						/* $("#create input[type='submit']").attr("disabled","disabled"); */
						
							/* 	$('.nextstep').click(function(){ */
									var myJson=new Array();
									$(".comment input").each(function(i,index){
										var obj=new Object();
										obj.id=$(index).attr('data_id');
										obj.number=$(index).val();
										if(obj.number!=0){
											myJson.push(obj);
										}
										
									})
									
									strjson = $.toJSON(myJson);
									console.log(strjson)
									if(strjson=='[]'){
										$("input[name='gifts']").attr("name","");
										$("#create input[type='submit']").attr("disabled","disabled"); 
										form.submit();
									}else{
										$(".pay_method").show();
										$(".pay_submit").on("click",function(){
											var pay=$('input:radio[name="payto_method"]:checked').val();
											/* alert(pay) */
											$("input[name='pay_method']").val(pay);
											/* alert($("input[name='pay_method']").val()) */
											$("input[name='gifts']").val(strjson);
											 $("#create input[type='submit']").attr("disabled","disabled"); 
											form.submit();

										})
									
									}
									
							/* }) */
						
						
						
						 
						
							
				}
		
			}); 
})
	</script>


@stop