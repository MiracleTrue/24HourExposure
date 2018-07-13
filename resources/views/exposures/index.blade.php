@extends('layouts.app')

@section('title', 'XXX')

@section('content')



    {{dump($categories)}}
    {{dump($exposures)}}
    {{dump($lbs)}}

    @include('common.error')


    <form action="{{route('payment.gift.alipay')}}" method="POST">
        {{csrf_field()}}

        <input type="hidden" name="exposure_id" value="8">
        <input type="hidden" name="gifts" value='[{"id":1,"number":1},{"id":7,"number":2}]'>

        <input type="submit" value="OK">
    </form>


@stop