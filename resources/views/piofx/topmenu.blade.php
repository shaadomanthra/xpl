  <nav class="js-mega-menu navbar navbar-expand-lg mt-1">
                        <div class="navbar-nav-wrap">
                            @if(!isset($menudark))
                            <!-- Logo -->
                            <a class="navbar-brand navbar-nav-wrap-brand" href="{{ url('/')}}"  aria-label="Front"> <img src="{{ asset('img/piofx-white.png')}}" alt="Logo"> </a>
                            <!-- End Logo -->
                            @else
                            <a class="navbar-brand navbar-nav-wrap-brand"  href="{{ url('/')}}" aria-label="Front"> <img src="{{ asset('img/piofx.png')}}" alt="Logo"> </a>
                            @endif
                            <!-- Secondary Content -->
                            <div class="navbar-nav-wrap-content text-center">
                                <div class="d-none d-lg-block">
                                    <a class="btn btn-sm btn-danger transition-3d-hover" href="{{ route('login')}}" >
                  Login </a>
                                </div>
                            </div>
                            <!-- End Secondary Content -->
                            <!-- Responsive Toggle Button -->
                            <button type="button" class="navbar-toggler navbar-nav-wrap-toggler btn btn-icon btn-sm rounded-circle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
                                <span class="navbar-toggler-default"> <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
                                    </svg> </span>
                                <span class="navbar-toggler-toggled"> <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                                    </svg> </span>
                            </button>
                            <!-- End Responsive Toggle Button -->
                            <!-- Navigation -->
                            <div id="navBar" class="collapse navbar-collapse navbar-nav-wrap-collapse">
                                <div class="navbar-body header-abs-top-inner">
                                    <ul class="navbar-nav">
                                        <li class="hs-has-mega-menu ">
                                            <a id="homeMegaMenu" class="hs-mega-menu-invoker nav-link " href="{{ url('/')}}" aria-haspopup="true" aria-expanded="false">Home</a>
                                        </li>
                                        <!-- Home -->
                                        <li class="hs-has-mega-menu ">
                                            <a id="homeMegaMenu" class="hs-mega-menu-invoker nav-link " href="" aria-haspopup="true" aria-expanded="false">For Corporates</a>
                                        </li>
                                        <!-- End Home -->
                                       <!-- Home -->
                                        <li class="hs-has-mega-menu ">
                                            <a id="homeMegaMenu" class="hs-mega-menu-invoker nav-link " href="" aria-haspopup="true" aria-expanded="false">For Schools</a>
                                        </li>
                                        <!-- End Home -->
                                        <!-- Home -->
                                        <li class="hs-has-mega-menu ">
                                            <a id="homeMegaMenu" class="hs-mega-menu-invoker nav-link " href="{{ url('oet')}}" aria-haspopup="true" aria-expanded="false">OET</a>
                                        </li>
                                        <!-- End Home -->
                                       
                                      
                                    </ul>
                                </div>
                            </div>
                            <!-- End Navigation -->
                        </div>
                    </nav>
                    <!-- End Nav -->