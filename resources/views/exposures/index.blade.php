@extends('layouts.app')

@section('content')
    @include('common.error')

    <header><span>可道</span> <a href="{{route('exposures.create')}}"></a></header>
    <div class="homebox">
        <div class="location">
            <!--定位-->
            {{--<div>--}}
                {{--<a href="{{ route('locations.relocation') }}" id="position">{{$lbs->city}}</a>--}}
            {{--</div>--}}
            <div>
                <form class="myselcct" action="{{route('exposures.index')}}" method="get">
                    <input type="text" name="search" placeholder="请输入对象名称精确查找"/>
                    <input type="submit" value="确定"/>
            </div>

        </div>

        <!--分类-->
        <div class="classification">
            <span>分类：</span>
            <div>
                <select name="category" class="categories">
                    <option value="">全部</option>
                    @foreach($categories as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <span>筛选：</span>
            <div>
                <select name="sort" class="sort">
                    <option value="">请选择</option>
                    <option value="created_time_desc">时间由先到后</option>
                    <option value="created_time_asc">时间由后到先</option>
                    <option value="gift_amount_more">礼物由多到少</option>
                    <option value="gift_amount_less">礼物由少到多</option>
                </select>
            </div>
            </form>

        </div>
        <!--对象列表-->
        <ul class="exposure_list">

            @foreach($exposures as $item)

                <li>
                    <a href="{{route('exposures.show',$item->id)}}">
                        <div></div>
                        <div>
                            {{--<img src="{{asset('web/img/baoguanglist.png')}}"/>--}}
                        </div>
                        <div>
                            <div class="title">
                                <span style="margin-right: 0.4rem;">{{$item->category->name}}</span>
                                <span>对象：</span>
                                <span>{{$item->name}}</span>
                            </div>
                            <div class="comment">


                                @foreach($item->gifts as $gift)


                                    <div title="{{$gift->title}}"><img style="" src="{{$gift->image_url}}">{{$gift->sum}}</div>
                                @endforeach

                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
        <!--今日资讯-->
        <div class="todynews">
            <div></div>
            @foreach($today_news as $item)
                <a href="{{route('news.show',$item->id)}}"><span style="margin-right: 10px;">今日资讯</span><span>{{$item->title}}</span></a>
            @endforeach

        </div>

        {{ $exposures->appends($filters)->render() }}

    </div>


    @include('layouts._footer')

    <script>
        var filters = {!! json_encode($filters) !!};
        console.log(filters);
        $(document).ready(function () {
            $('.categories').val(filters.category);
            $('.sort').val(filters.sort);
            $("input[name='search']").val(filters.search);
        });
        $(".categories").change(function () {
            $(".myselcct").trigger('submit');
        })
        $(".sort").change(function () {
            $(".myselcct").trigger('submit');
        })
    </script>

@stop