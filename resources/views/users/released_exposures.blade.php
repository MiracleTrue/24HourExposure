@extends('layouts.app')

@section('content')
    @include('common.error')
    <div class="myexposurebox">
        <div class="header">
            <a href="javascript:history.go(-1)" class="goback"><</a>
            <span>我发过的对象</span>
            <a href="{{route('exposures.create')}}" class="add"><img src="{{asset('web/img/fabubutton.png')}}"/></a>
        </div>
        <div class="news_serach">
            <div>
                <form class="myselcct" action="{{route('users.released_exposures')}}" method="get">
                    <input name="search" type="text" placeholder="请输入标题查询对应文章"/>
                    <input type="submit" value="搜索"/>

            </div>
            <div>
                <div><span>分类：</span>
                    <select name="category" class="categories">
                        <option value="">全部</option>
                        @foreach($categories as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div><span>时间：</span>
                    <select name="time" class="selcct_time">
                        <option value="">请选择</option>
                        <option value="7_days">最近7天</option>
                        <option value="last_month">最近一个月</option>
                        <option value="half_year">最近半年</option>
                    </select></div>
                </form>
            </div>
        </div>

        <ul class="exposure_list">
            @foreach($exposures as $item)
                <li>
                    <a href="{{route('exposures.show',$item->id)}}">
                        <div class="customer">
                            <span class="category">{{$item->category->name}}</span>
                            <img src="{{$item->user->avatar_url}}"/>
                            <span>发布人 : {{$item->user->name}}</span>
                            <p><span>对象：</span><span>{{$item->name}}</span></p>
                        </div>

                        <p>{{$item->title}}</p>
                        <span class="date">{{$item->created_at}}</span>
                    </a>
                </li>
            @endforeach


        </ul>
        <!--page-->
        {{ $exposures->appends($filters)->render() }}
    </div>
    <script>
        var filters = {!! json_encode($filters) !!};
        console.log(filters);
        $(document).ready(function () {
            $('.categories').val(filters.category);
            $('.selcct_time').val(filters.time);
            $("input[name='search']").val(filters.search);
        });
        $(".categories").change(function () {
            $(".myselcct").trigger('submit');
        })
        $(".selcct_time").change(function () {
            $(".myselcct").trigger('submit');
        })
    </script>




@stop