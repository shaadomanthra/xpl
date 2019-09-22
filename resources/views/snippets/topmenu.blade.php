<nav class="navbar navbar-expand-lg navbar-dark " >
    @guest
    <a class="navbar-brand abs" href="{{ url('/') }}" aria-label="Homepage">
        <picture>
          <source srcset="{{ asset('img/packetprep_75.webp') }}"
          width="60px" class="logo-main ml-md-1"  alt="packetprep logo " type="image/webp">
          <source srcset="{{ asset('img/packetprep_75.png') }}"
          width="60px" class="logo-main ml-md-1" alt="packetprep logo " type="image/png"> 
          <img 
          src="{{ asset('img/packetprep_75.png') }} " width="60px" class="logo-main ml-md-1"  alt="packetprep logo " type="image/png">
      </picture>
  </a>
  @else
  <a class="navbar-brand abs" href="{{ url('/dashboard') }}" aria-label="Dashboard">
    <picture>
      <source srcset="{{ asset('img/packetprep_75.webp') }}"
      width="60px" class="logo-main ml-md-1"  alt="packetprep logo " type="image/webp">
      <source srcset="{{ asset('img/packetprep_75.png') }}"
      width="60px" class="logo-main ml-md-1" alt="packetprep logo " type="image/png"> 
      <img 
      src="{{ asset('img/packetprep_75.png') }} " width="60px" class="logo-main ml-md-1"  alt="packetprep logo " type="image/png">
  </picture>
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
        <li class="mr-3 "><a class="nav-link " href="{{ url('course') }}" aria-label="PacketPrep Courses"><i class="fa fas fa-youtube-play"></i> Courses</a></li>

        <li class="mr-3 "><a class="nav-link " href="{{ url('firstacademy') }}" aria-label="Abroad Study Preparation"><i class="fa fas fa-gg"></i> Abroad Studies</a></li>
                    <!--
                        <li class="mr-3 "><a class="nav-link " href="{{ url('tracks') }}"><i class="fa fa fa-spotify"></i> Tracks</a></li>   -->
                        <li class="mr-3 "><a class="nav-link " href="{{ url('wipro-nth-2020') }}" aria-label="Wipro NTH 2020"><i class="fa fa-ravelry"></i> Wipro NTH 2020</a></li>

                        <li class="mr-3 "><a class="nav-link " href="{{ url('ambassador') }}" aria-label="Internship at packetprep"><span class="badge badge-warning p-1 pl-2 pr-2"> Internship</span></a></li>

                        <li class="nav-item dropdown mr-2">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="dropdown menu">
                             <i class="fa fa-bullseye"></i>  Programs <span class="caret"></span>
                         </a>
                         <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item"  href="{{ url('gigacode')}}" aria-label="Gigacode program"
                            >
                            GigaCode 
                        </a>
                        <a class="dropdown-item"  href="{{ url('bootcamp')}}" aria-label="Coding Bootcamp program"
                        >
                        Coding Bootcamp
                    </a>
                    <a class="dropdown-item"  href="{{ url('targettcs')}}" aria-label="Target TCS NQT"
                        >
                        Target TCS NQT
                    </a>



                </div>  
            </li>

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
                

            @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','tpo']))
            <a class="dropdown-item"  href="{{ route('campus.admin') }}"></i> Campus Admin</a>
            @endif 

            @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee']))
            <a class="dropdown-item"  href="{{ route('admin.index') }}"></i> Admin</a>
            @endif

            @if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','ambassador','coordinator','tpo']))
            <a class="dropdown-item"  href="{{ route('referral')}}"
            >
            Referrals
        </a>
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