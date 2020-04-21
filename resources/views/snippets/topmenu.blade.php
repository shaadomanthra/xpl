<nav class="navbar navbar-expand-lg navbar-light " >
    @guest
    <a class="navbar-brand abs" href="{{ url('/') }}" aria-label="Homepage">
        <img 
          src="{{ asset('img/xplore.png') }} " width="100px" class="ml-md-1"  alt="Xplore logo " type="image/png">
  </a>
  @else
  <a class="navbar-brand abs" href="{{ url('/dashboard') }}" aria-label="Dashboard">
    <img 
          src="{{ asset('img/xplore.png') }} " width="100px" class="ml-md-1"  alt="Xplore logo " type="image/png">
</a>   
@endguest
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav" style="font-weight: bold">
    <ul class="navbar-nav ">

    </ul>
    <ul class="navbar-nav ml-auto mt-4 mt-lg-0">
        @guest
        @else


        <li class="mr-3"><a class="nav-link" href="{{ route('dashboard') }}" aria-label="Dashboard page"
            ><i class="fa fa-dashboard"></i>
            Dashboard
        </a></li>

        @endguest

        @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
        <li class="mr-3 "><a class="nav-link " href="{{ url('exam') }}" aria-label="Tests"><i class="fa fa-inbox"></i> Tests</a></li>
        @else

        <li class="mr-3 "><a class="nav-link " href="{{ url('course') }}" aria-label="PacketPrep Courses"><i class="fa fas fa-youtube-play"></i> Courses</a></li>

        
                    <!--
                        <li class="mr-3 "><a class="nav-link " href="{{ url('tracks') }}"><i class="fa fa fa-spotify"></i> Tracks</a></li>   -->
                        <li class="mr-3 "><a class="nav-link " href="{{ url('test') }}" aria-label="Wipro NTH 2020"><i class="fa fa-ravelry"></i> Tests</a></li>

                        <li class="mr-3 "><a class="nav-link " href="{{ url('job') }}" aria-label="Wipro NTH 2020"><i class="fa fa-bars"></i> Jobs</a></li>

        @endif

        

                        
            <!-- Authentication Links -->
            @guest
            <li class="mr-2"><a class="nav-link " href="{{ route('login') }}" aria-label="Login page"><i class="fa fa-sign-in"></i> Login</a></li>
            <li class="mr-2"><a class="nav-link " href="{{ route('register.type') }}" aria-label="Registration page"><i class="fa fa-user-plus"></i> Register</a></li>

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

            


@if(!\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))
        <a class="dropdown-item"  href="{{ route('order.transactions') }}"
        >
        Transactions
    </a>
    @endif
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