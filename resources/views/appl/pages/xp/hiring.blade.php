 @include('appl.pages.xp.snippets.header')
  @include('appl.pages.xp.snippets.topmenu')

  <!-- ========== MAIN ========== -->
  <main id="content" role="main" class="pt-9">
    <!-- Hero Section -->
    <div class="container-fluid p-0 " style="background-color:#FFEBEE ;">
    <div class="container space-top-3 space-top-lg-3 space-bottom-1 space-bottom-lg-1">
        <div class="row justify-content-lg-between mb-4">
            <div class="col-md-6 col-lg-5" >
            <!-- Info -->
              <div class="mb-5">
                  <h1>Hiring made easy</h1>
                  <p>Xplore provides you with the best tools to screen your candidates so you can make bettrer, faster and easier hiring decision.</p>
              </div>

              <div class="mb-3">
                  <a class="btn btn-danger btn-wide transition-3d-hover mb-2 mb-sm-0 mr-3" href="contact">Try for free</a>
                  <a class="btn btn-link text-danger mb-2 mb-sm-0" href="https://youtu.be/2b0Hb2_5f2Q">Watch Video<i class="fas fa-angle-right fa-sm ml-1"></i></a>
              </div>

            
            <!-- End Info -->
            </div>

            <div class="col-md-6 d-none d-md-inline-block">
            <!-- SVG Illustration -->
              <figure class="w-90">
                  <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/undraw_Online_learning_re_qw08.svg')}}" alt="Image Description">
              </figure>
            <!-- End SVG Illustration -->
            </div>

        </div>
      </div>

    </div>
 <svg class="p-0 m-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 250"><path fill="#FFEBEE " fill-opacity="1" d="M0,96L60,106.7C120,117,240,139,360,154.7C480,171,600,181,720,160C840,139,960,85,1080,80C1200,75,1320,117,1380,138.7L1440,160L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path></svg>
    <!-- End Hero Section -->
    <!-- Icon Blocks Section -->
    <div class="container space-bottom-2">
    <!-- Title -->
    <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
      
        <h2 class="h2">Administer tests with ease</h2>
    </div>
    <!-- End Title -->

    <div class="row">
        <div class="col-md-4 mb-5 mb-md-0">
        <!-- Icon Blocks -->
        <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-4">
            <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/contract.svg')}}" alt="SVG">
            </figure>
            
            <h4>Test anyone, any where, any time</h4>
            <p>Xplore makes it easy to test your candidaes. Use a simple testing link in your online job posting, or invite candidates to take assessments at any stage of your hiring process.</p>
        </div>
        <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4 mb-5 mb-md-0">
        <!-- Icon Blocks -->
        <div class="text-center px-lg-3">
            <figure class="max-w-10rem mx-auto mb-4">
            <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/statistics.svg')}}" alt="SVG">
            </figure>
           
            <h4>Tests for any position and industry</h4>
            <p>Our customers use our platform to hire across just every industry and job type. Xplore recommendes the right tests for you, with custom test batteries for over 1,100 positions.</p>
        </div>
        <!-- End Icon Blocks -->
        </div>

        <div class="col-md-4">
        <!-- Icon Blocks -->
        <div class="text-center px-lg-2">
            <figure class="max-w-10rem mx-auto mb-4">
            <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/boss.svg')}}" alt="SVG">
            </figure>
           
            <h4>Test as much as you need</h4>
            <p>With Xplore, you get unlimited testing across our entire assessment portfolio, enabling you to scale with ease.</p>
        </div>
        <!-- End Icon Blocks -->
        </div>
    </div>
    </div>
    <!-- End Icon Blocks Section -->
    <!-- Article Section -->
     <h2 class="mb-3 text-center">Employability tests for different skills and abilites </h2>
    <div class="container space-1">     
    <div class="row mx-n2" style="a:hover">
        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/speedometer.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Aptitude Test</h3>
                <p class="text-body">Quantitative, Reasoning Verbal.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>

        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/technical-support.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Technical Test</h3>
                <p class="text-body">Programming concepts, Syntax  errors, Logical errors.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>
        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/html.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Coding Test</h3>
                <p class="text-body">C, Java, Python, Javascript.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>

        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/teamwork.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>English proficiency Test</h3>
                <p class="text-body">Listening, Speaking, Reading, Writing.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>
        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/test.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Psychometric Test</h3>
                <p class="text-body">Big 5 metrics.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>

        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/video-recording.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Video Tests</h3>
                <p class="text-body">Audio, Video recordings.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>
        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/responsive.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Descriptive Test</h3>
                <p class="text-body">Writing, image uploading.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>

        <div class="col-md-6 px-2 mb-3 ">
        <!-- Icon Block -->
        <a class="card card-frame h-90" href="#">
            <div class="card-body">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/keyboard.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h3>Typing Test</h3>
                <p class="text-body">WPM, Accuracy.</p>
                </div>
            </div>
            </div>
        </a>
        <!-- End Icon Block -->
        </div>
        
    </div>
    </div>
    <!-- End Article Section -->
    <!-- Features Section -->
     <h1 class="mb-2 text-center text-danger">Features that matters</h1>
      <h2 class="mt-4 text-center ">Platform features</h2>
    <div class="container space-2">
    <div class="w-lg-100 mx-lg-auto pl-md-0 pl-3">
        <div class="row">
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/simple.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Simple</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/internet.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Customizable</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/protection.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Secure</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/monitoring.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Scalable</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/smartphone.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Mobile ready</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/wifi.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Works in low bandwidth</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/power-strip.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Power failure ready</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/promote.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Brand promotion</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/terminal.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>White labelling</h4> 
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/call-center-agent.svg')}} " alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Dedicated Support</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        
        </div>
    </div>
    </div>
    <!-- End Features Section -->
    <!-- Features Section -->
    <div class="container-fluid bg-soft-warning pt-5">
    <h2 class="mt-3 text-center ">Security features</h2>
    <div class="container space-2">
    <div class="w-lg-100 mx-lg-auto">
        <div class="row">
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/artificial-intelligence.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>AI proctoring</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/simulator.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Human proctoring</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/warning.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Window swap detection</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/margin.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Cut, copy, paste disabled</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/agent.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Photo Id detection</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/personal-computer.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>System check</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/email_secure.svg')}}  " alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Email based restriction</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/pin-code.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Access code based restriction</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/terminal.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Auto termination contraint</h4> 
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5"> 
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/reading-book.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Manual termination constraint</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/browser.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Secure browser support</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/password.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Complete user logs</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/take-a-photo.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Webcam captures</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/videoconference.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Screen captures</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/interface.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Role band permisions</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/cloud-storage.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Cloud backup</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/chatting.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Chat with candidates</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-3">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/speak.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Broad cast messages</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>
    </div>
    <!-- End Features Section -->
       <!-- Features Section -->
  
      <h2 class="text-center mt-7">Assessment features</h2>
    <div class="container space-2">
    <div class="w-lg-100 mx-lg-auto pl-md-0 pl-3">
        <div class="row">
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/question.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Question library</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/faq.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Numerous question paper</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/question_marking.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Question/sectional marking</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/repeat.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Question/option shuffling</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/smartphone_cal.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>On screen calculator</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/data_compiler.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Code compiler</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="w-100"></div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/questions_dynamic.svg')}}  " alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Dynamic question</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

         <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/clipboards.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Dynamic set papers</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/news-reporter.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>comprehensive student reports</h4> 
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/presentation_report.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Question analysis</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/xls.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Excel download </h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/pdf.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>User response sheet pdf</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
        <div class="w-100"></div>

        <div class="col-md-6 mb-3 mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/test_correction.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Manual correction</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>

        <div class="col-md-6  mb-md-5">
            <div class="media">
                <figure class="w-100 max-w-6rem mr-3">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/toggle.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Auto enable\disable tests</h4>
                <p class="text-body">Once your team signs up for a subscription plan. </p>
                </div>
            </div>
        </div>
       
        </div>
    </div>
    </div>
    <!-- End Features Section -->
    <!-- step Section -->
    <div class="overflow-hidden bg-light">
      <div class="container space-2">
        <div class="row justify-content-lg-between align-items-lg-center">
          <div class="col-lg-6 mb-9 mb-lg-0">
            <!-- Mockups -->
            <div class="position-relative max-w-50rem mx-auto">
              <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/undraw_education_f8ru.svg')}}" alt="no image">
            </div>
            <!-- End Mockups -->
          </div>

          <div class="col-lg-5">`
            <div class="mb-5">
              <h2>How it Works</h2>
            </div>

            <!-- Icon Block -->
            <ul class="step step-dashed mb-7">
              <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-xs step-icon-soft-primary">1</span>
                  <div class="step-content">
                    <h3 class="h4">Create test</h3>
                    <p>Choose the most appropriate ready to go test or get a custom test created by our subject matters expects within 24 hours.</p>
                  </div>
                </div>
              </li>
              <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-xs step-icon-soft-primary">2</span>
                  <div class="step-content">
                    <h3 class="h4">Invite candidates</h3>
                    <p>Invite candidates to complete the assessment via email or test links.</p>
                  </div>
                </div>
              </li>
             <li class="step-item">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-xs step-icon-soft-primary">3</span>
                  <div class="step-content">
                    <h3 class="h4">Review scores</h3>
                    <p>Receive real time notifications and shortlisted qualified candidates.</p>
                  </div>
                </div>
              </li>
              <li class="step-item mb-0">
                <div class="step-content-wrapper">
                  <span class="step-icon step-icon-xs step-icon-soft-primary">4</span>
                  <div class="step-content">
                    <h4>Hire</h4>
                    <p class="mb-0">Interview the shortlisted candidates and close the role within a day.</p>
                  </div>
                </div>
              </li>
            </ul>
            <!-- End Icon Block -->

            <div class="mt-2">
              <a class="btn btn-soft-dark transition-3d-hover px-4" href="contact">Get started now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End step Section -->

    <!-- CTA Section -->
    <div class="container space-1 mb-2">
      <div class="text-center py-6"
        style="background: url({{ asset('assetsfront/svg/components/abstract-shapes-19.svg')}}) center no-repeat;">
        <h2>Get started for Free!</h2>
        <p>Test drive our use-friendly assessment platform.</p>
        <span class=" button d-block mt-5">
          <a class=" corporates_btn2  transition-3d-hover" href="contact">Start Now</a>
        </span>
      </div>
    </div>
    <!-- End CTA Section -->
    
  </main>
  <!-- ========== END MAIN ========== -->

  @include('appl.pages.xp.snippets.footermenu')
@include('appl.pages.xp.snippets.footer')