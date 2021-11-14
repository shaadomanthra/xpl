@include('appl.pages.xp.snippets.header')
  @include('appl.pages.xp.snippets.topmenu')
  <!-- ========== MAIN ========== -->
  <main id="content" role="main" class="pt-md-8">
   
    <!-- Hero Section -->
    <div class="position-relative" style="background-color: #E0F7FA;">
      <div class="space-top-3 space-bottom-2">
        <div class="container mt-lg-11 ">
          <!-- Content -->
          <div class="row">
            <div class="col-lg-6 col-xl-6">
              <div class="mb-5">
                <h1 class="display-4">One stop solution for learning and hiring</h1>
                <p class="lead">Technology training, Hiring assessments, Verifiable <br>e-certificates, Campus placements, Proctored exams, <br>all in a single interface.</p>
              </div>
            <!-- buttons -->
            <div class="hero_btn mb-5">
             <a href="contact"><button type="button" class="btn btn-outline  px-4" >Request a demo</button></a>
             <!-- <a href="#"><button type="button" class="btn btn-outline-info px-4">Login</button></a> -->
            </div>
            <!-- End buttons -->
            </div>
          </div>
          <!-- End Content -->
        </div>
        
        <div class="transform-rotate-5 ">
          <div class="d-none d-lg-flex flex-lg-wrap align-items-lg-end position-absolute top-0 left-50 transform-rotate-6" style="width: 45rem;">
            <!-- Device Mockup -->
            <div class="device device-horizontal-ipad mr-4 mb-4" style="width: 23rem;" data-aos="fade-up" data-aos-delay="200" data-aos-offset="-100">
              <img class="device-horizontal-ipad-frame img-fluid" src="{{ asset('assetsfront/svg/components/ipad-horizontal.svg')}}" alt="Image Description">
              
              <img class="device-horizontal-ipad-screen img-fluid" src="{{ asset('assetsfront/xploreImages/face-detection.jpeg')}}" alt="Image Description">
              
            </div>
            <!-- End Device Mockup -->

            <!-- Device Mockup -->
            <div class="device device-ipad mb-4" style="width: 17rem;" data-aos="fade-up" data-aos-delay="500" data-aos-offset="-500">
              <img class="device-ipad-frame img-fluid" src="{{ asset('assetsfront/svg/components/ipad.svg')}}" alt="Image Description">
              <img class="device-ipad-screen img-fluid" src="{{ asset('assetsfront/xploreImages/Video Assessments.jpg')}}" alt="Image Description">
            </div>
            <!-- End Device Mockup -->

            <!-- Device Mockup -->
            <div class="device device-iphone-x align-self-start" style="width: 8rem;" data-aos="fade-up" data-aos-delay="100" data-aos-offset="-1000">
              <img class="device-iphone-x-frame img-fluid" src="{{ asset('assetsfront/svg/components/iphone-x.svg')}}" alt="Image Description">
              <img class="device-iphone-x-screen img-fluid" src="{{ asset('assetsfront/xploreImages/Mobile Ready.jpg')}}" alt="Image Description">
            </div>
            <!-- End Device Mockup -->

            <!-- Device Mockup -->
            <div class="device mr-4" style="width: 35rem;"  data-aos="fade-up"  data-aos-offset="-1000">
              <img class="img-fluid" src="{{ asset('assetsfront/svg/components/macbook.svg')}}" alt="Image Description">
              <img class="device-macbook-screen img-fluid" src="{{ asset('assetsfront/xploreImages/CODING.jpg')}}" alt="Image Description">
            </div>
            <!-- End Device Mockup -->

            <!-- SVG Shape -->
            <!-- <figure class="max-w-23rem w-100 position-absolute bottom-0 left-0 z-index-n1" data-aos="fade-up" data-aos-delay="300" data-aos-offset="-400">
              <div class="mb-n7 ml-n11">
                <img class="img-fluid" src="{{ asset('assetsfront/svg/components/abstract-shapes-10.svg')}}" alt="Image Description">
              </div>
            </figure> -->
            <!-- End SVG Shape -->
          </div>
        </div>
      </div>

      <!-- SVG Bottom Shape -->
      <!-- <figure>
        <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
          <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z"/>
        </svg>
      </figure> -->
      <!-- End SVG Bottom Shape -->
    </div>
        <svg xmlns="http://www.w3.org/100/svg" viewBox="0 0 1440 280"><path fill="#E0F7FA" fill-opacity="1" d="M0,128L20,117.3C40,107,80,85,120,90.7C160,96,200,128,240,122.7C280,117,320,75,360,53.3C400,32,440,32,480,58.7C520,85,560,139,600,160C640,181,680,171,720,160C760,149,800,139,840,117.3C880,96,920,64,960,80C1000,96,1040,160,1080,170.7C1120,181,1160,139,1200,133.3C1240,128,1280,160,1320,160C1360,160,1400,128,1420,112L1440,96L1440,0L1420,0C1400,0,1360,0,1320,0C1280,0,1240,0,1200,0C1160,0,1120,0,1080,0C1040,0,1000,0,960,0C920,0,880,0,840,0C800,0,760,0,720,0C680,0,640,0,600,0C560,0,520,0,480,0C440,0,400,0,360,0C320,0,280,0,240,0C200,0,160,0,120,0C80,0,40,0,20,0L0,0Z"></path></svg>

    <!-- End Hero Section -->
    <!-- Featured Articles Section -->
    <div class="container space-bottom-2">
      <div class="pb-6 pb-lg-9 text-center">
        <!-- <h4>Solutions</h4> -->
        <h2>One platform for all needs</h2>
      </div>
      <div class="d-flex flex-wrap align-items-baseline justify-content-md-between justify-content-center text-center text-md-left">
        <div class=" mb-5 mb-md-0 ">
          <!-- SVG Icon -->
          <figure class="w-100 max-w-8rem mb-4 mx-auto mx-md-0">
            <img class="img-fluid " src="{{ asset('assetsfront/xploreImages/building.svg')}}" alt="SVG">
          </figure>
          <!-- End SVG Icon -->

          <div class="mb-4">
            <h3>Xplore for Corporates</h3>
          </div>

          <ul class="list-unstyled list-article">
            <li><a class="link-underline" href="hiring">Hiring Assessments</a></li>
            <li><a class="link-underline" href="jobboard">Job Board</a></li>
            <li><a class="link-underline" href="corporate-training">Corporate Training</a></li>
            
          </ul>
        </div>

        <div class=" mb-5 mb-md-0">
          <!-- SVG Icon -->
          <figure class="w-100 max-w-8rem mb-4 mx-auto mx-md-0">
            <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/bank.svg')}}" alt="SVG">
          </figure>
          <!-- End SVG Icon -->

          <div class="mb-4">
            <h3>Xplore for Institutions</h3>
          </div>

          <ul class="list-unstyled list-article">
            <li><a class="link-underline" href="#">Campus Recruitment Training</a></li>
            <li><a class="link-underline" href="#">Company Specific Training</a></li>
            <li><a class="link-underline" href="#">Proctored Online Examination</a></li>
            <li><a class="link-underline" href="xpc">Xplore Placement Club</a></li>
          </ul>
        </div>
        <div class="">
          <!-- SVG Icon -->
          <figure class="w-100 max-w-8rem mb-4 mx-auto mx-md-0">
            <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/teamwork_stds.svg')}}" alt="SVG">
          </figure>
          <!-- End SVG Icon -->

          <div class="mb-4">
            <h3>Xplore for Students</h3>
          </div>

          <ul class="list-unstyled list-article">
            <li><a class="link-underline" href="xpc">Xplore Placement Club</a></li>
            <li><a class="link-underline" href="#">Finishing School Program</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Featured Articles Section -->
    <!-- Testimonials Section -->
    <div class="bg-light rounded mx-3 mx-md-11">
      <div class="container space-1 space-md-2">
        <div class="card bg-transparent shadow-none">
          <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
              <div class="dzsparallaxer auto-init height-is-based-on-content use-loading mode-scroll bg-light" data-options='{direction: "reverse"}' style="overflow: visible;">
                <div data-parallaxanimation='[{property: "transform", value:" translate3d(0,rem,0)", initial:"4", mid:"0", final:"-4"}]'>
                  <img class="img-fluid rounded shadow-lg" src="{{ asset('assetsfront/xploreImages/textimonial_img.jpeg')}}" alt="Image Description">

                  <!-- SVG Shapes -->
                  <figure class="max-w-15rem w-100 position-absolute bottom-0 left-0 z-index-n1">
                    <div class="mb-n7 ml-n7">
                      <img class="img-fluid" src="{{ asset('assetsfront/svg/components/dots-5.svg')}}" alt="Image Description">
                    </div>
                  </figure>
                  <!-- End SVG Shapes -->
                </div>
              </div>
            </div>

            <div class="col-lg-9">
              <!-- Card Body -->
              <div class="card-body h-100 rounded p-0 p-md-4">
                <!-- SVG Quote -->
                <figure class="mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="36" height="36" viewBox="0 0 8 8">
                    <path fill="#377dff" d="M3,1.3C2,1.7,1.2,2.7,1.2,3.6c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5
                      C1.4,6.9,1,6.6,0.7,6.1C0.4,5.6,0.3,4.9,0.3,4.5c0-1.6,0.8-2.9,2.5-3.7L3,1.3z M7.1,1.3c-1,0.4-1.8,1.4-1.8,2.3
                      c0,0.2,0,0.4,0.1,0.5c0.2-0.2,0.5-0.3,0.9-0.3c0.8,0,1.5,0.6,1.5,1.5c0,0.9-0.7,1.5-1.5,1.5c-0.7,0-1.1-0.3-1.4-0.8
                      C4.4,5.6,4.4,4.9,4.4,4.5c0-1.6,0.8-2.9,2.5-3.7L7.1,1.3z"/>
                  </svg>
                </figure>
                <!-- End SVG Quote -->

                <div class="row">
                  <div class="col-lg-12 mb-3 mb-lg-0">
                    <div class="pr-lg-5">
                      <blockquote class="h3 font-weight-normal mb-4">It's been an amazing journey with Xplore Careers. <br>
                       You've been out there helping us whenever and wherever needed. I would like to thank the entire Xplore team for being so generous to add new features in your product in the snap of a finger, on our request. It's because of Xplore, we were able to hire good resources.</blockquote>
                      <div class="media">
                        <div class="avatar avatar-xs avatar-circle d-lg-none mr-2">
                          <img class="avatar-img" src="{{ asset('assetsfront/xploreImages/textimonial_img.jpeg')}}" alt="Image Description">
                        </div>
                        <div class="media-body">
                          <span class="text-dark font-weight-bold">Navya P</span>
                          <span class="font-size-1">— Talent magnet - Technovert & Keka</span>
                        </div>
                      </div>
                    </div>
                  </div> 
                </div>
              </div>
              <!-- End Card Body -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Testimonials Section -->
    <!-- Features Section -->
    <div class="container space-2">
      <div class="row justify-content-lg-between">
        <div class="col-lg-5 order-lg-2 pl-lg-0">
          <div class="bg-img-hero h-100 min-h-450rem rounded" style="background-image: url({{ asset('assetsfront/img/900x900/img19.jpg')}});"></div>
        </div>

        <div class="col-lg-6 order-lg-1">
          <div class="pt-8 pb-lg-8">
            <!-- Title -->
            <div class="mb-5 mb-md-7">
              <h2 class="mb-3">Take the recruitment assessment to the next level with our platform</h2>
              <p>Recruitment is not a cakewalk, and nobody understands this better than us. Over the years, we have observed the need for campus hiring solution and come up with the best plan to find the right talent for companies.
                <br> <br> Xplore helps you transform your business by finding the perfect people - right from choosing the colleges to efficiently training people once they are hired. Our expert team will help you at every step to ensure seamless candidate experience.</p>
            </div>
            <!-- End Title -->

            <div class="row">
              <div class="col-6 mb-3 mb-md-5">
                <div class="pr-lg-4">
                  <span class="js-counter h2 text-primary">150000+</span>
                  <span class="h2 text-primary">+</span>
                  <p>Registered students.</p>
                </div>
              </div>

              <div class="col-6 mb-3 mb-md-5">
                <div class="pr-lg-4">
                  <span class="js-counter h2 text-primary">4000</span>
                  <span class="h2 text-primary">+</span>
                  <p>Students placed.</p>
                </div>
              </div>

              <div class="col-6">
                <div class="pr-lg-4">
                  <span class="js-counter h2 text-primary">300</span>
                  <span class="h2 text-primary">+</span>
                  <p>College network.</p>
                </div>
              </div>

              <div class="col-6">
                <div class="pr-lg-4">
                  <span class="js-counter h2 text-primary">40</span>
                  <span class="h2 text-primary">+</span>
                  <p>Corporate Connect.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Features Section -->
    <!-- Icon Blocks Section -->
      <div class="container space-2">
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
        
          <h2 class="h1">Address The Challenges:</h2>
        </div>
        <!-- End Title -->

        <div class="row">
          <div class="col-md-4 mb-5 mb-md-0">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
              <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/hand.svg')}}" alt="SVG">
              </figure>
              <h3>Identify Quality<br>and Quantity</h3>
              <p>Get accurate insights by planning your campus drive with Xplore. We help you pick colleges that perfectly fit your quality parameters.</p>
            </div>
            <!-- End Icon Blocks -->
          </div>

          <div class="col-md-4 mb-5 mb-md-0">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
              <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/save_time.svg')}}" alt="SVG">
              </figure>
              <h3>Save Time</h3>
              <p> With Xplore, you can easily save time and effort in travelling to different colleges for hiring. An added advantage - you already know your candidate before even entering the campus!</p>
            </div>
            <!-- End Icon Blocks -->
          </div>

          <div class="col-md-4">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
              <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/training_deploye.svg')}}" alt="SVG">
              </figure>
              <h3>Reduce &<br>Training-Deployment</h3>
              <p>Xplore offers ‘Job-ready programs’ that help you get a higher ROI. Hence, when you hire from campuses registered with us, you reduce the lead time in training and shadow deployment.</p>
            </div>
            <!-- End Icon Blocks -->
          </div>
        </div>
      </div>
      <!-- End Icon Blocks Section -->
      <!-- Articles Section -->
      <h2 class="text-center">Why Choose Us?</h2>
      <div class="container space-2">
        <div class="w-lg-100 mx-lg-auto">
          <div class="row">
            <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/netoworking.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Colossal Network</h3>
                      <p class="text-body">We are connected to over 300 colleges across India which gives you access to lakhs of students</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>

            <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/relax.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Hassle-Free</h3>
                      <p class="text-body">Leave all operational hassles to us. With a platform like Xplore, you can sit back while we source the best candidates from broader geographies.</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/mission.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Branding</h3>
                      <p class="text-body">With Xplore, you can find not only the right talent but also win the branding game. You can upload your company logo for the candidates to get familiar with your brand.</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/short-term.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Get Access To Insights</h3>
                      <p class="text-body">We offer in-depth reporting and insights to optimize the complete process. You can easily export the reports and share.</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/test.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Custom Tests</h3>
                      <p class="text-body">We offer a wide range of questions (10,000 +). You can create your own tests as well from scratch based on the requirements.  </p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/artificial-intelligence.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>AI-based Proctoring</h3>
                      <p class="text-body">Our AI-based online proctoring is used for identity verification and cheating prevention. You can select genuine performers.</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/test_correction.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Predefined Assessments</h3>
                      <p class="text-body">Our Skill test is a comprehensive assessment which checks a candidate’s aptitude, domain knowledge, technical as well as communication skills. Finding the best candidate is now easy.</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
             <div class="col-md-6 mb-3 mb-2">
              <!-- Icon Block -->
              <a class="card h-100 transition-3d-hover" href="#">
                <div class="card-body">
                  <div class="media">
                    <figure class="w-100 max-w-7rem mr-3">
                      <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/impression.svg')}}" alt="SVG">
                    </figure>
                    <div class="media-body">
                      <h3>Expertise</h3>
                      <p class="text-body">Find the right talent by leveraging our expertise. We are a team of highly experienced individuals with an experience of 20 years in this industry. We know what you need!</p>
                    </div>
                  </div>
                </div>
              </a>
              <!-- End Icon Block -->
            </div>
          </div>
        </div>
      </div>
      <!-- End Articles Section -->
    <!----------start college logos ------>
    <div class="container space-1 ">
      <h2 class="text-center mb-lg-9 mb-7">Trusted by 300+ organizations</h2>
      <div class="row container align-items-center">
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
          <img class=" img-fluid" style="max-width: 75px !important;"  src="{{ asset('assetsfront/xploreImages/padmavathi logo.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
         <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/iiit_kunool.png')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/vaggdevi logo.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/gurunanak.png')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
        <img class=" img-fluid" style="max-width: 65px !important;"  src="{{ asset('assetsfront/xploreImages/mrce.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="10">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/QIS logo.jpg')}}.crdownload" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/swarnandhra.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/rgukt.png')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/jbet.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
          <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/Vemu logo.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
        <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/st-martin-s-engineering-college-hyderabad-logo.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="20">
          <img class=" img-fluid" style="max-width: 70px !important;"  src="{{ asset('assetsfront/xploreImages/swec.webp')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/Innominds-Logo.webp')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
        <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/ZenQ.png')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/mouri-logo.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
        <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/24-7-logo.jpg')}}" alt="">
        </div>
         <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/yupptv.jpg')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="30">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/Machint.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/N-logo.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/magnaquest.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/qualitlabsLogo.jpg')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/invescoLogo.webp')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/inventizLogo.png')}}" alt="">
        </div>
        <div class="col-md-2 col-4 mb-6 text-center" data-aos="fade-up" data-aos-delay="40">
          <img class=" img-fluid" style="max-width: 85px !important;"  src="{{ asset('assetsfront/xploreImages/GlobalLogic-Logo.png')}}" alt="">
        </div>
      </div>
    </div>
    <!----------end college logos ------>
    <!-- CTA Section -->
    <div class="container space-bottom-1 mb-2">
      <div class="text-center py-6"
        style="background: url({{ asset('assetsfront/svg/components/abstract-shapes-19.svg')}}) center no-repeat;">
        <h2>Hire The Best From The Leading Colleges </h2>
        <!-- <p>Answer a few questions and match your goals to our programs.</p> -->
        <span class=" button d-block mt-5">
          <a class=" corporates_btn2  transition-3d-hover" href="contact">Let’s Connect</a>
        </span>
      </div>
    </div>
    <!-- End CTA Section -->
    
  </main>
  <!-- ========== END MAIN ========== -->





  <!-- Go to Top -->
  <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {`
         "init": {
           "right": 15
         },
         "show": {
           "bottom": 15
         },
         "hide": {
           "bottom": -15
         }
       }
     }'>
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- End Go to Top -->



@include('appl.pages.xp.snippets.footermenu')
@include('appl.pages.xp.snippets.footer')