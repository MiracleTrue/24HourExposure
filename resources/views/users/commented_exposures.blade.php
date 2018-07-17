@extends('layouts.app')

@section('title', 'XXX')

@section('content')


    {{dump($categories)}}

    {{dump($exposures)}}

    @include('common.error')



    @include('layouts._footer')


@stop