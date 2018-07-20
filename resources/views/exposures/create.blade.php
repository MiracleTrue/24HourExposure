@extends('layouts.app')

@section('title','')

@section('content')
 
	<div class="addbox">
		<div class="header">
			<a href="javascript:history.go(-1)" class="goback"><</a>
			<span>增加曝光</span>
			
		</div>
		@include('common.error')
		<form class="create" action="{{ route('exposures.store') }}" method="post">
			<div>
			<p>
				<span>选择分类：</span>
				<select name="category_id" >
					<option value="">全部</option> 
					@foreach($categories as $item)
						<option value="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				</select>
			</p>
			<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>曝光对象：</span>
					<input name="name" type="" placeholder=""  />
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>标题：</span>
					<input name="title" type="text" placeholder="请输入要曝光的对象" />
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p class="content">
					<span>内容：</span>
					<textarea name="content"></textarea>
				</p>
				<span class="tipinfo"></span>
			</div>
			<input type="hidden" name="gifts" value=''>
			<div class="comment">
				
				@foreach($gifts as $item)
					<div style="display: flex;"  title="{{$item->title}}"><img style="" src="{{$item->image_url}}"><input data_id="{{$item->id}}" style="width: 0.4rem;border: 1px solid #999999;height: 0.57rem;text-align: center;" type="number" min="0" value="0"/> <p class="gift_num"><span class="add" >+</span><span class="reduce">-</span></p>               </div>
				@endforeach	
			</div>
			<input class="nextstep" type="submit" value="提交"/ >
		</form>
	</div>
    
   <script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
   <script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/validate-methods.js')}}"></script>
	 <script type="text/javascript" src="{{asset('web/library/jqueryJson/jquery.json.js')}}"></script>

	<script>

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
					$('.nextstep').click(function(){ 
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
							$("input[name='gifts']").val(strjson);
						}
						
				}) 
			
		
		
	  $(".create").validate({
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
				error.appendTo( element.parent().parent().find(".tipinfo"));                            //这里的element是录入数据的对象
				},
				submitHandler: function(form) {
						
						$(form).submit();
							
				}
		
			}); 
})
	</script>


@stop