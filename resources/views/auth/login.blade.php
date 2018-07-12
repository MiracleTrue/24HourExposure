@extends('layouts.app')

@section('content')
@include('common.error')

<div class="loignbox">
	<div class="head">
		<a href="javascript:history.go(-1)" class="goback"><</a>
		<span>登录</span>
		<a href="register.php">注册</a>
	</div>
	<div>
		<form class="loginform">
			<div>
				<p>
					<span>账号：</span>
					<input type="text" name="phone" placeholder=""/>
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>密码：</span>
					<input type="password" name="password" />
				</p>
				<span class="tipinfo"></span>
			</div>
			
			
			
				<input type="submit"value="登录" />	
				
		
			
		</form>
	</div>
</div>


<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script src="{{asset('web/library/jquery.form/jquery.form.js')}}"></script>
<script>
	$(function(){
		var register = $(".loginform").validate({
				rules: {
					phone: {
						required: true,
						isMobile:true
		
					},
					
					password:{
						required:true,
						minlength:6
					}
						
				},
				messages: {
					phonenum: {
						required: "请输入账号",
						isMobile: "请输入正确账号"
		
					},
					
					password:{
						required:'请输入密码',
						minlength:'密码不得少于6位'
					}
				},
				errorPlacement: function(error, element) {                            
					error.appendTo( element.parent().parent().find(".tipinfo"));                           
				},
				submitHandler: function(form) {
					 $(form).ajaxSubmit({
						url: "{{ route('login') }}",
						type: 'post',
						dataType: 'JSON',
						success: function(res) {
							
						},
						error:function(XMLHttpRequest){
							console.log(XMLHttpRequest)
							if(XMLHttpRequest.status==422){
								
								var errorsMassage="";
								for(var i in JSON.parse( XMLHttpRequest.responseText).errors){
									console.log(JSON.parse( XMLHttpRequest.responseText).errors[i])
									errorsMassage+=JSON.parse( XMLHttpRequest.responseText).errors[i];
								}
								alert(errorsMassage);
							} 
						}
					}); 
				}
		
			});
		
	})
</script>
@include('layouts._footer')
@endsection
