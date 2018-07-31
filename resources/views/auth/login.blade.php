@extends('layouts.app')

@section('content')


<div class="loignbox">
	<div class="head">
		<a href="javascript:history.go(-1)" class="goback"><</a>
		<span>登录</span>
		<a style="position: absolute;right: 0.24rem;top: 50%;margin-top: -0.5rem;" href="{{route('register')}}">注册</a>
	</div>
	@include('common.error')
	<div>
		<form id="loginform" class="loginform" action="{{ route('login') }}" method="post">
			{{ csrf_field() }}
			<div>
				<p>
					<span>手机号：</span>
					<input class="phone" type="text" name="phone" placeholder=""/>
				</p>
				<span class="tipinfo"></span>
			</div>
			<div>
				<p>
					<span>密码：</span>
					<input class="password" type="password" name="password" />
				</p>
				<span class="tipinfo"></span>
			</div>

				<input type="submit" value="登录" />	
		</form>
	</div>
</div>
<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>-->
<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/validate-methods.js')}}"></script>
<script type="text/javascript">
	$().ready(function() {
		
		
		$("#loginform").validate({
				rules: {
					phone: {
						required: true,
					},
					password:{
						required:true,
						minlength:6
					}
						
				},
				messages: {
					phone: {
						required: "请输入账号",
					},
					
					password:{
						required:'请输入密码',
						minlength:'密码不得少于6位'
					}
				},
				errorPlacement: function(error, element) {                            
					error.appendTo(element.parent().parent().find(".tipinfo"));
				},
				submitHandler: function(form) {
                    $("#loginform input[type='submit']").attr("disabled","disabled");
					form.submit();
				}
			});
	})
</script>
@include('layouts._footer')
@endsection
