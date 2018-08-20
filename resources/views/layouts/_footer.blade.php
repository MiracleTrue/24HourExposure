<footer>
    <div class="" style="z-index: 100;">
        <ul>
            <li class="{{
            active_class(if_route('exposures.index'))
            }}"><a href="{{route('exposures.index')}}"><i
                            class="fa fa-warning fa-2x"></i><span>可道</span></a></li>

            <li class="{{
            active_class(if_route('news.index'))
            }}"><a href="{{route('news.index')}}"><i class="fa fa-file-text-o fa-2x"></i><span>资讯中心</span></a></li>

            <li class="{{
            active_class(if_route('users.index'))
            }}"><a href="{{route('users.index')}}"><i class="fa fa-user-circle-o fa-2x"></i><span>个人中心</span></a></li>

        </ul>
    </div>
</footer>