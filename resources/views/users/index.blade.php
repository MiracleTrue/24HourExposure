@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')


    {{--{{dd($user)}}--}}


    <a href="{{route('users.edit',$user->id)}}">修改资料</a>


@stop