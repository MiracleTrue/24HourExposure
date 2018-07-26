@extends('layouts.app')

@section('title', $user->name . '修改资料')

@section('content')

	<div class="modifybox">
		<div class="header">
			<a href="{{ route("users.index") }}" class="goback"><</a>
			<span>修改资料</span>	
		</div>
		<form class="imgsubmit" method="post" enctype="multipart/form-data"> 
		{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT" />
			<p style="position: relative;">
				<span>头像：</span>
				<img class="avatar" src="{{$user->avatar_url}}"  />
				<input name="avatar" style="width: 0.55rem;height: 0.55rem;position: absolute;right: 0.24rem;opacity: 0;" class="uploadimg"  type="file" accept="image/*" onchange="uploadImg()" />
			</p>
		</form>
		<p>
			<span>电话号码：</span>
			<span class="disabled" onclick='disabled()'>{{$user->phone}}</span>
		</p>
		<form class="namesubmit">
			<p>
				<input type="hidden" name="_method" value="PUT" />
				<span>昵称：</span>
				<input class="nameedit"  name="name" type="text" value="{{$user->name}}" onchange="namesubmit(this)" />
			</p>
		</form>
		<p>
			<span>身份证号：</span>
			<span class="disabled" onclick='disabled()'>{{$user->id_card}} </span>
		</p>

			<a class="logout" style="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					退出登录
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					{{ csrf_field() }}
			</form>
		
		
	</div>
	<script src="{{asset('web/library/jquery.form/jquery.form.js')}}"></script>
	<script>
		function uploadImg(){
			$(".imgsubmit").ajaxSubmit({
				url: '{{ route("users.update",$user->id) }}',
				type:"post",
				success: function(res) {
					console.log(res);
					var avatar_url=res.user.avatar_url;
					$('.avatar').attr("src",avatar_url);
				}
		
			});
		}
		function namesubmit(ele){
				$(".namesubmit").ajaxSubmit({
					url: '{{ route("users.update",$user->id) }}',
					type:"post",
					data:{
						_token:'{{csrf_token()}}'
					},
					success: function(res) {
						console.log(res);
						$(ele).val(res.user.name )
					}
			
				});
				
		}
		function disabled(){
			alert("电话号码和身份证号不可修改")
		}
		
		
	</script>


@stop