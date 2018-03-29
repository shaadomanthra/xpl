 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fff;">
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
                    <li><a class="nav-link" href="{{ route('apply') }}">Apply Now</a></li>
                    @else
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/')}}">Home </a>
                    </li>

                    @if(\Auth::user()->checkRole(['administrator','investor','patron','promoter','employee']))
                    <li><a class="nav-link" href="{{ route('system') }}">System</a></li>
                    @endif

                    <li><a class="nav-link" href="{{ route('material') }}">Material</a></li>

                    <li><a class="nav-link" href="{{ route('root') }}">Recruit</a></li>

                    @if(\Auth::user()->checkRole(['administrator','editor','social-media-moderator','social-media-writer','blog-moderator','blog-writer','employee']))
                    <li><a class="nav-link" href="{{ route('social') }}">Social</a></li>
                    @endif


                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           {{ Auth::user()->name }} <span class="caret"></span>
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item"  href="{{ route('profile','@'.Auth::user()->username) }}"
                            >
                            Profile
                             </a>
                            <a class="dropdown-item"  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Logout
                             </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>  
                     </li>
                    @endguest
                 </ul>
            </div>
        </nav>  