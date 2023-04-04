<!-- ========== HEADER ========== -->
  <header id="header" class="header nav-shadow bg-light  position-fixed">

    <div id="logoAndNav" class="container">
      <!-- Nav -->
      <nav class="js-mega-menu navbar navbar-expand-lg d-flex justify-content-between">
        <!-- Logo -->
        <a href="/" aria-label="Front">
          <img src="{{ asset('assetsfront/xploreImages/xplore.png')}}" width="100" alt="Logo">
        </a>
        <!-- End Logo -->
        <div>
          <a class="signup_btn ml-3 d-lg-none" href="login">Login</a>

          <!-- Responsive Toggle Button -->
          <button type="button" class="navbar-toggler btn btn-icon btn-ghost-dark" aria-label="Toggle navigation"
            aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
            <span class="navbar-toggler-default">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor"
                  d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z" />
              </svg>
            </span>
            <span class="navbar-toggler-toggled">
              <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor"
                  d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
              </svg>
            </span>
          </button>
          <!-- End Responsive Toggle Button -->
        </div>

        <!-- Navigation -->
        <div id="navBar" class="collapse navbar-collapse">
          <ul class="navbar-nav">
            <!-- products -->
            <li class="hs-has-sub-menu navbar-nav-item">
              <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle" href="javascript:;"
                aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu">Products</a>

              <!-- Products - Submenu -->
              <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                style="min-width: 230px;">
                <a href="hiring" class="dropdown-item"><i class="fab fa-slideshare nav-icon ml-1"></i></i>Hiring Assessment</a>
                <a href="jobboard" class="dropdown-item"><i class="fas fa-user-tie nav-icon ml-1"></i>Job Board</a>
                <!--<a href="./colleges.html" class="dropdown-item"><i class="fas fa-laptop-code nav-icon"></i>Proctored Online Examination</a> -->
                <a href="xpc" class="dropdown-item"><i class="fas fa-users nav-icon"></i>Xplore placement club</a>
              </div>
              <!-- End Products - Submenu -->

            </li>
            <!-- End Products -->

            <li class="navbar-nav-item ml-lg-2">
              <a href="course" class="nav-link">Courses</a>
            </li>

            <!-- trainings -->
            <!-- <li class="hs-has-sub-menu navbar-nav-item">
              <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle" href="javascript:;"
                aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu">Training</a>

              <!-- trainings - Submenu -->
              <!-- <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                style="min-width: 230px;">
                <a href="./corporates.html" class="dropdown-item"><i class="fas fa-building nav-icon"></i> For
                  Corporates</a>
                <a href="./schools.html" class="dropdown-item"><i class="fas fa-school nav-icon"></i>For Schools</a>
                <a href="./colleges.html" class="dropdown-item"><i class="fas fa-graduation-cap nav-icon"></i>For
                  Colleges</a>
                <a href="#" class="dropdown-item"><i class="fas fa-university nav-icon"></i>For Institutes</a>
              </div> -->
              <!-- End trainings - Submenu -->

            </li> 
            <!-- End trainings -->

            <li class="navbar-nav-item ml-lg-2">
              <a href="test" class="nav-link">Tests</a>
            </li>

            <!-- events -->
            <!-- <li class="hs-has-sub-menu navbar-nav-item">
              <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle" href="javascript:;"
                aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu">Events</a> -->

              <!-- events - Submenu -->
              <!-- <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                style="min-width: 230px;">
                <a href="./corporates.html" class="dropdown-item"><i class="fas fa-chalkboard-teacher nav-icon"></i> Virtual</a>
                <a href="./schools.html" class="dropdown-item"><i class="fas fa-desktop nav-icon"></i>AP Eamcet mock Test</a>
              </div> -->
              <!-- End events - Submenu -->

            </li>
            <!-- End events -->
           <li class="navbar-nav-item ml-lg-2">
              <a href="job" class="nav-link">Jobs</a>
            </li>
           <!-- resources -->
            <!-- <li class="hs-has-sub-menu navbar-nav-item">
              <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link nav-link-toggle" href="javascript:;"
                aria-haspopup="true" aria-expanded="false" aria-labelledby="pagesSubMenu">Resources</a> -->

              <!-- resources - Submenu -->
              <!-- <div id="pagesSubMenu" class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu"
                style="min-width: 230px;">
                <a href="./corporates.html" class="dropdown-item"><i class="fas fa-file-video nav-icon"></i> Videos</a>
                <a href="./schools.html" class="dropdown-item"><i class="fas fa-pen-square nav-icon"></i>Testimonials</a>

                <a href="#" class="dropdown-item"><i class="fas fa-blog nav-icon"></i>Blog</a>
              </div> -->
              <!-- End resources - Submenu -->

            </li>
            <!-- End resources -->

            <!-- Contact -->
           
            <li class="navbar-nav-item ml-lg-2">
              <a href="register" class="nav-link">Register</a>
            </li>
            <!-- End Contact -->

            <!-- Sign Up -->
            <li class="navbar-nav-item ml-lg-3 mt-3 mt-lg-0 d-none d-lg-block">
              <a class="signup_btn" href="login">Login</a>
            </li>
            <!-- End Sign Up -->
          </ul>
        </div>
        <!-- End Navigation -->
      </nav>
      <!-- End Nav -->
    </div>
    <div class=" p-2" style="background: #eecf3e;color:black;"> 
      <div class="container">
        Register for FREE MOCK EAMCET TEST now <a href="https://tseamcet.xplore.co.in"><span class="badge badge-primary">Click Here</span></a>
      </div>
    </div>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->