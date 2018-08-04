<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c3e50;">
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ">
                    

                    <!-- Authentication Links -->
                    @guest
                    <li><a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i>  Login</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}"><i class="fa fa-bars"></i>  Register Now</a></li>
                    @else
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/')}}"><i class="fa fa-home"></i> Dashboard </a>
                    </li>

                    @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','intern']))
                    <li><a class="nav-link" href="{{ route('system') }}"><i class="fa fa-user"></i> Profile</a></li>
                    @endif


                    @if(\Auth::user()->checkRole(['administrator','investor','patron','promoter','data-manager','data-lead','feeder','proof-reader','renovator','validator','restructure-lead','thinker','manager','employee']))
                    <li>
                    	<a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Logout
                             </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                    </li>
                    @endif
                   
                    @endguest
                 </ul>
            </div>
        </nav>  