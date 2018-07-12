@extends('layouts.app')

@section('title', $user->name . '修改资料')

@section('content')

    {{dump($user)}}
	<div class="modifybox">
		<div class="header">
			<a href="javascript:history.go(-1)" class="goback"><</a>
			<span>修改资料</span>	
		</div>
		<p>
			<span>头像：</span>
			<img src="assets/img/touxiang.png" />
		</p>
		<p>
			<span>电话号码：</span>
			<span class="disabled" onclick='disabled()'>13888888888</span>
		</p>
		<p>
			<span>昵称：</span>
			<input type="text" value="132" />
		</p>
		<p>
			<span>身份证号：</span>
			<span class="disabled" onclick='disabled()'>1255555555</span>
		</p>

	</div>
	<script>
		function disabled(){
			alert("电话号码和身份证号只能在后台修改")
		}
	</script>


@endsection