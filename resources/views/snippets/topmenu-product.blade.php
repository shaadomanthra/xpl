<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c3e50;">
            <a class="navbar-brand mr-1" href="{{ url('/') }}">
                <img class="logo-small img-fluid" alt="Responsive image" src="{{ asset('/img/packetprep-logo-min.png') }}" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ">
                    

                    <!-- Authentication Links -->
                    @guest
                    <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                     <li><a class="nav-link" href="{{ route('job.index') }}">Blog</a></li>
                    <li><a class="nav-link" href="{{ route('job.index') }}">Apply Now</a></li>
                    @else
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/')}}">Dashboard </a>
                    </li>

                    @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','intern']))
                    <li><a class="nav-link" href="{{ route('system') }}">Profile</a></li>
                    @endif

                    @if(\Auth::user()->checkRole(['administrator','investor','patron','promoter','data-manager','data-lead','feeder','proof-reader','renovator','validator','restructure-lead','thinker','manager','employee']))
                    <li><a class="nav-link" href="{{ route('material') }}">Exam Information</a></li>
                    @endif

                    @if(\Auth::user()->checkRole(['administrator','investor','patron','promoter','data-manager','data-lead','feeder','proof-reader','renovator','validator','restructure-lead','thinker','manager','employee']))
                    <li>
                    	<a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Logout
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