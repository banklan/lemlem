<nav class="navbar navbar-default navbar-static-top admin_nav" id="{{ Request::is('/') ? 'welcome_nav' : 'gen_nav'}}">
            <!-- <div class="container"> -->
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <!-- &nbsp; -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- <li class="{{ \Request::is('make_orders') ? 'active' : '' }}"><a href="{{ route('make-orders') }}">Make Order</a></li> -->
                        <!-- <li class="{{ \Request::is('home') ? 'active' : '' }}"><a href="{{ route('home') }}">Dashboard</a></li> -->
                        <!-- Authentication Links -->
                        @guest
                            <!-- <li class="{{ \Request::is('login') ? 'active' : '' }}"><a href="{{ route('login') }}">Login</a></li> -->
                            <!-- <li class="{{ \Request::is('register') ? 'active' : '' }}"><a href="{{ route('register') }}">Register</a></li> -->
                        @else
                            <li class="{{ \Request::is('home') ? 'active' : '' }}"><a href="{{ route('admin.home') }}">Admin Dashboard</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::guard('admin')->user()->fullname }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            <!-- </div> -->
        </nav>