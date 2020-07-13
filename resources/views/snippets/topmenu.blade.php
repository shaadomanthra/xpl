<nav class="navbar navbar-expand-lg navbar-light " >
    

    @guest
    <a class="navbar-brand abs" href="{{ url('/') }}" aria-label="Homepage">
    @else
    <a class="navbar-brand abs" href="{{ url('/dashboard') }}" aria-label="Dashboard">
    @endguest
        @if($_SERVER['HTTP_HOST'] == 'bfs.piofx.com' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test')
        <img 
        src="{{ request()->session()->get('client')->logo }} " height="50px" class="ml-md-0"  alt="logo " type="image/png">
        @elseif($_SERVER['HTTP_HOST'] == 'xplore.co.in' || $_SERVER['HTTP_HOST'] == 'xp.test')
        <img 
          src="{{ asset('img/xplore.png') }} " width="100px" class="ml-md-1"  alt="Xplore logo " type="image/png">
        @else
        <img 
        src="{{ request()->session()->get('client')->logo }} " height="80px" class="ml-md-0"  alt="logo " type="image/png">
        @endif
    </a>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav" style="font-weight: bold">
    <ul class="navbar-nav ">

    </ul>
    <ul class="navbar-nav ml-auto mt-4 mt-lg-0">
        @guest

        <li class="mr-3 "><a class="nav-link @if(request()->route('/')) active @endif" href="{{ url('/') }}" aria-label="Hir"><i class="fa efas fa-angle-right"></i> For student</a></li>

        <li class="mr-3 "><a class="nav-link " href="{{ url('hire') }}" aria-label="Hir"><i class="fa efas fa-angle-right"></i> For companies</a></li>

        <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fa efas fa-angle-right"></i> Services <span class="caret"></span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item"  href="{{ url('course') }}"
                    >
                    <i class="fa fas fa-youtube-play"></i> Courses
                </a>
                <a class="dropdown-item"  href="{{ url('test') }}"
                    >
                    <i class="fa fa-ravelry"></i> Tests
                </a>
                <a class="dropdown-item"  href="{{ url('job') }}"
                    >
                   <i class="fa fa-bars"></i> Jobs</a>
                </a>


            </div>


        
                    <!--
                        <li class="mr-3 "><a class="nav-link " href="{{ url('tracks') }}"><i class="fa fa fa-spotify"></i> Tracks</a></li>   -->
                        

                        
                        
        @else


        <li class="mr-3"><a class="nav-link" href="{{ route('dashboard') }}" aria-label="Dashboard page"
            ><i class="fa fa-dashboard"></i>
            Dashboard
        </a></li>

        @if(\Auth::user()->checkRole(['hr-manager']) && !\Auth::user()->isAdmin())
            <li class="mr-3 "><a class="nav-link " href="{{ url('post') }}" aria-label=""><i class="fa fa-ravelry"></i> Job Post</a></li>
        @else
             <li class="mr-3 "><a class="nav-link " href="{{ url('course') }}" aria-label="PacketPrep Courses"><i class="fa fas fa-youtube-play"></i> Courses</a></li>
            <li class="mr-3 "><a class="nav-link " href="{{ url('test') }}" aria-label=""><i class="fa fa-ravelry"></i> Tests</a></li>
            <li class="mr-3 "><a class="nav-link " href="{{ url('joblist') }}" aria-label="Wipro NTH 2020"><i class="fa fa-bars"></i> Jobs</a></li>

        @endif

        @endguest


        
        

        

                        
            <!-- Authentication Links -->
            @guest
            <li class="mr-2"><a class="nav-link " href="{{ route('login') }}" aria-label="Login page"><i class="fa fa-sign-in"></i> Login</a></li>
            <li class="mr-2"><a class="nav-link " href="{{ route('register') }}" aria-label="Registration page"><i class="fa fa-user-plus"></i> Register</a></li>

            @else

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 {{ Auth::user()->name }} <span class="caret"></span>
             </a>
             <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item"  href="{{ route('profile','@'.\auth::user()->username)}}"
                    >
                    Profile
                </a>
                

           
            @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
            <a class="dropdown-item"  href="{{ route('admin.index') }}"></i> Admin</a>
            @endif

            



        <a class="dropdown-item"  href="{{ route('order.transactions') }}"
        >
        Transactions
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