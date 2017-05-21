<header class="navbar navbar-fixed-top navbar-inverse">
<div class="container">
    <div class="col-md-offset-1 col-md-10">
        <a href="/" id="logo">Myweb</a>
        <nav>
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li><a href="#">Users lists</a></li><!-- 用户列表 -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->name }} <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('users.show', Auth::user()->id) }}">User Center</a></li><!-- 个人中心 -->
                            <li><a href="#">Edit Profile</a></li><!-- 编辑资料 -->
                            <li class="divider"></li>
                            <li>
                                <a id="logout" href="#">
                                    <form action="{{ route('logout') }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-block btn-danger" type="submit" name="button">Sign Out</button>
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('help') }}">help</a></li><!-- 帮助 -->
                    <li><a href="{{ route('login') }}">login</a></li><!-- 登录 -->
                @endif
            </ul>
        </nav>
    </div>
</div>
</header>