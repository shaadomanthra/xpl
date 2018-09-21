
 <nav class="navbar navbar-expand-lg navbar-light " >
            <a class="navbar-brand abs" href="{{ url('/') }}">
                <img src="{{ asset('/img/logo-onlinelibrary.png') }}" width="200px" class="logo-main ml-md-1" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="font-weight: bold">
                <ul class="navbar-nav ">
                     
                 </ul>
                 <ul class="navbar-nav ml-auto">
                    
                    <li class="mr-3 mt-2 mt-lg-0"><a class="nav-link " href="{{ url('/') }}"><i class="fa fas fa-home"></i> Home</a></li>

                    
                    
                    

                    <!-- Authentication Links -->
                    @guest

                    <li class="mr-3  mt-lg-0"><a class="nav-link " href="{{ url('faq') }}"><i class="fa fas fa-question-circle"></i> FAQ</a></li>
                   <li class="mr-3 "><a class="nav-link " href="{{ url('pricing') }}"><i class="fa fa-rupee"></i> Pricing</a></li>
                    
                    <li class="mr-2"><a class="nav-link " href="{{ route('login') }}"><i class="fa fa-sign-in"></i> Login</a></li>
                    
                    @else
                   
                   @if(!\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
                    
                    <li class="mr-3  mt-lg-0"><a class="nav-link " href="{{ url('faq') }}"><i class="fa fas fa-question-circle"></i> FAQ</a></li>
                   <li class="mr-3 "><a class="nav-link " href="{{ url('pricing') }}"><i class="fa fa-rupee"></i> Pricing</a></li>
                   @endif
                   
                    @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
                    <li><a class="nav-link" href="{{ route('team') }}"><i class="fa fa-users"></i> Team</a></li>
                    @endif
                    
                    @if(\Auth::user()->checkRole(['administrator','investor','patron','promoter','data-manager','data-lead','feeder','proof-reader','renovator','validator','restructure-lead','thinker','manager','employee']))
                    <li><a class="nav-link" href="{{ route('material') }}"><i class="fa fa-th"></i> Material</a></li>
                    @endif

                    @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','marketing-manager','marketing-executive']))
                    <li><a class="nav-link" href="{{ route('client.index') }}"><i class="fa fa-university"></i> Clients</a></li>
                    @endif

                    @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','marketing-manager','marketing-executive']))
                    <li><a class="nav-link" href="{{ url('downloads-corporate') }}"><i class="fa fa-download"></i> Downloads</a></li>
                    @endif

                    <li class="nav-item dropdown"> 
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user"></i>
                           {{ Auth::user()->name }} <span class="caret"></span>
                       </a>
                       <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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