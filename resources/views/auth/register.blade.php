@extends('layouts.app')

@section('content')

		<div class="loignbox registerbox">
			
			<div class="head">
				<a href="javascript:history.go(-1)" class="goback"><</a>
				<span>注册</span>
				
			</div>
			@include('common.error')
			<div>
				
				<form class="registerform form-horizontal"  method="POST" action="{{ route('register') }}" >
					<div>
						<p>
								<span>手机号：</span>
								<input class="phonenum form-control" type="text" name="phone" value="" />
								<input class="code" type="button" value="获取验证码" name="code" onclick="sendCode(this)"/>
						</p>
					
						<span class="tipinfo"></span>
					</div>
					<div>
						<p>
							<span>验证码：</span>
							<input class="form-control" id="verification_code" type="text" name="verification_code"  />
						</p>
						<span class="tipinfo"></span>
					</div>
					<div>
						<p>
							<span>输入密码：</span>
							<input type="password" id="password" name="password"  />
						</p>
						<span class="tipinfo"></span>
					</div>
					<div>
						<p>
							<span>确认密码：</span>
							<input id="password-confirm" type="password" name="password_confirmation"/>
						</p>
						<span class="tipinfo"></span>
					</div>
					<div>
						<p>
							<span>身份证：</span>
							<input id="id_card" type="text" name="id_card" value="{{ old('id_card') }}" />
						</p>
						<span class="tipinfo"></span>
					</div>
					
					<p style="position: relative;"><input type="submit" value="注册" /></p>
					
				</form>
			</div>
		</div>
		
		<!--<div class="container">
		        <div class="row">
		            <div class="col-md-8 col-md-offset-2">
		                <div class="panel panel-default">
		                    <div class="panel-heading">Register</div>
		
		                    <div class="panel-body">
		                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
		                            {{ csrf_field() }}
		
		
		                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
		                                <label for="phone" class="col-md-4 control-label">Phone</label>
		
		                                <div class="col-md-6">
		                                    <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}">
		
		                                    @if ($errors->has('phone'))
		                                        <span class="help-block">
		                                        <strong>{{ $errors->first('phone') }}</strong>
		                                    </span>
		                                    @endif
		                                </div>
		                            </div>
		
		                            <div class="form-group{{ $errors->has('verification_code') ? ' has-error' : '' }}">
		                                <label for="verification_code" class="col-md-4 control-label">verification_code</label>
		
		                                <div class="col-md-6">
		                                    <input id="verification_code" type="verification_code" class="form-control" name="verification_code"
		                                           value="{{ old('verification_code') }}">
		
		                                    @if ($errors->has('verification_code'))
		                                        <span class="help-block">
		                                        <strong>{{ $errors->first('verification_code') }}</strong>
		                                    </span>
		                                    @endif
		                                </div>
		                            </div>
		
		                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		                                <label for="password" class="col-md-4 control-label">Password</label>
		
		                                <div class="col-md-6">
		                                    <input id="password" type="password" class="form-control" name="password">
		
		                                    @if ($errors->has('password'))
		                                        <span class="help-block">
		                                        <strong>{{ $errors->first('password') }}</strong>
		                                    </span>
		                                    @endif
		                                </div>
		                            </div>
		
		                            <div class="form-group">
		                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
		
		                                <div class="col-md-6">
		                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
		                                </div>
		                            </div>
		
		                            <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
		                                <label for="id_card" class="col-md-4 control-label">id_card</label>
		
		                                <div class="col-md-6">
		                                    <input id="id_card" type="id_card" class="form-control" name="id_card" value="{{ old('id_card') }}">
		
		                                @if ($errors->has('id_card'))
		                                            <span class=" help-block">
		                                    <strong>{{ $errors->first('id_card') }}</strong>
		                                    </span>
		                                    @endif
		                                </div>
		                            </div>
		
		
		                            <div class="form-group">
		                                <div class="col-md-6 col-md-offset-4">
		                                    <button type="submit" class="btn btn-primary">
		                                        Register
		                                    </button>
		                                </div>
		                            </div>
		                        </form>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>-->
		<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/jquery.validate.js')}}"></script>
		<script type="text/javascript" src="{{asset('web/library/jquery.validation/1.14.0/validate-methods.js')}}"></script>
		<script src="{{asset('web/library/jquery.form/jquery.form.js')}}"></script>
		<script>
			var clock = '';
			 var nums = 5;
			 var btn;
			 function sendCode(thisBtn){
				 var phonereg=/^[1][3,4,5,7,8][0-9]{9}$/;
				 var phoneNum=$(".phonenum").val();
				 
				 if(phonereg.test(phoneNum) || true){
					 btn = thisBtn;
					 btn.disabled = true; 
					 btn.value = nums+'秒后获取';
					 clock = setInterval(doLoop, 1000);
					 $(thisBtn).parent().parent().find('.tipinfo').text("");
					 $.ajax({
						 type:'post',
						 url:'{{ route("phone_verification.store") }}',
						 async:true,
						 data:{
							 phone:$(".phonenum").val()
						 },
						 success:function(res){
							 /* console.log(res) */
						 },
						 error:function(XMLHttpRequest, textStatus, errorThrown){
							 console.log(XMLHttpRequest);
								console.log(JSON.parse( XMLHttpRequest.responseText));
								console.log(JSON.parse( XMLHttpRequest.responseText).errors);
							 console.log(XMLHttpRequest.status);
								if(XMLHttpRequest.status==422){
									
									var errorsMassage="";
									for(var i in JSON.parse( XMLHttpRequest.responseText).errors){
										console.log(JSON.parse( XMLHttpRequest.responseText).errors[i])
										errorsMassage+=JSON.parse( XMLHttpRequest.responseText).errors[i];
									}
									alert(errorsMassage);
								}
							
							
							
						 }
						 
					 })
				 }else{
					 $(thisBtn).parent().parent().find('.tipinfo').text("请输入正确手机号");
				 }
				
			 }
			 function doLoop(){
				 nums--;
				 if(nums > 0){
					btn.value = nums+'秒后获取';
				 }else{
					clearInterval(clock); 
					btn.disabled = false;
					btn.value = '获取验证码';
					nums = 5; 
				 }
			 }
			
			
			 $(function(){
				 
				 	var register = $(".registerform").validate({
				 			rules: {
				 				phone: {
				 					required: true,
				 					isMobile:true
				 	
				 				},
								verification_code:{
									required: true
								},
								password:{
									required:true,
									minlength:6
								},
								password_confirmation:{
									required:true,
									 equalTo: "#password"
								},
								id_card:{
									required:true,
									isIdCardNo:true
								}
									
				 			},
				 			messages: {
				 				phone: {
				 					required: "请输入手机号",
				 					isMobile: "请输入正确手机号"
				 	
				 				},
								verification_code:{
									required: "请输入验证码",
								},
								password:{
									required:'请输入密码',
									minlength:'密码不得少于6位'
								},
								password_confirmation:{
									required:"请输入确认密码",
									equalTo: "两次密码输入不一致"
								},
								id_card:{
									required: "请输入身份证号",
									isIdCardNo:"请输入正确的身份证号"
								}
								
				 	
				 			},
							errorPlacement: function(error, element) {                             //错误信息位置设置方法
							 error.appendTo( element.parent().parent().find(".tipinfo"));                            //这里的element是录入数据的对象
							 },
							debug:false,			
				 			submitHandler: function(form) {
										$("input[type='submit']").attr("disabled","disabled");
										$(form).submit();
										
				 			}
				 	
				 		});
				 
			 })
			
		</script>
@endsection
