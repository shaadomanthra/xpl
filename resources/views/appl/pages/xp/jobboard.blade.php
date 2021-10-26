 @include('appl.pages.xp.snippets.header')
  @include('appl.pages.xp.snippets.topmenu')


  <!-- ========== MAIN ========== -->
  <main id="content" role="main" class="pt-9">
    <!-- Hero Section -->
      <div class="container space-2 space-lg-3">
        <div class="row align-items-lg-center">
          <div class="col-lg-5 mb-7 mb-lg-0" data-aos="fade-up" data-aos-duration="1800" data-aos-delay="500">
            <div class="mb-4">
              <h1>Find the Best candidates in minutes </h1>
              <span class="badge text-white px-4 py-1 font-size-2" style="background-color: #e24d4b;">Post a job for FREE</span>
              <p class="pt-2" style="font-size: 19px;">Leverage the network of 400+ engineering colleges and 1.5 lakh validated fresher profiles.</p>
            </div>

          </div>

          <div class="col-lg-7" data-aos="fade-down" data-aos-duration="1800" data-aos-delay="500">
            <img class="img-fluid" src="{{ asset('assetsfront/svg/illustrations/we-are-in-office-1.svg')}}" alt="Image Descriptio">
          </div>
        </div>
      </div>
      <!-- End Hero Section -->
        <!-- Clients Section -->
        <div class="container space-1 " height="60px">
        <div class="js-slick-carousel slick d-flex align-items-center justify-content-center"
            data-hs-slick-carousel-options='{
                "slidesToShow": 5,
                "autoplay": true,
                "autoplaySpeed": 5000,
                "infinite": true,
                "responsive": [{
                "breakpoint": 1200,
                "settings": {
                    "slidesToShow": 4
                }
                }, {
                "breakpoint": 992,
                "settings": {
                    "slidesToShow": 4
                }
                }, {
                "breakpoint": 768,
                "settings": {
                    "slidesToShow": 3
                }
                }, {
                "breakpoint": 576,
                "settings": {
                    "slidesToShow": 3
                }
                }]
            }'>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/jbet.jpg')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/mrce.jpg')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/padmavathi logo.jpg')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/QIS logo.jpg.crdownload')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/swarnandhra.jpg')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/vaggdevi logo.jpg')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/Vemu logo.png')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/iiit_kunool.png')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/gurunanak.png')}}" width="50px" alt="Image Description">
        </div>
        <div class="js-slide">
            <img class="max-w-11rem max-w-md-13rem mx-auto align-items-center" src="{{ asset('assetsfront/xploreImages/iiitRk_valley.webp')}}" width="50px" alt="Image Description">
        </div>
        </div>
        </div>
        <!-- End Clients Section -->

       <!-- step Section -->
        <div class="overflow-hidden bg-soft-danger">
        <div class="container space-2">
            <div class="row justify-content-lg-between align-items-lg-center">
            <div class="col-lg-6 mb-9 mb-lg-0">
                <!-- Mockups -->
                <div class="position-relative max-w-60rem mx-auto">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/undraw_Selecting_team_re_ndkb.svg')}}" alt="no image">
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
                    <span class="step-icon step-icon-xs step-icon-soft-danger">1</span>
                    <div class="step-content">
                        <h3 class="h4">Post a job</h3>
                        <p>Choose the most appropriate ready to go test or get a custom test created by our subject matters expects within 24 hours.</p>
                    </div>
                    </div>
                </li>
                <li class="step-item">
                    <div class="step-content-wrapper">
                    <span class="step-icon step-icon-xs step-icon-soft-danger">2</span>
                    <div class="step-content">
                        <h3 class="h4">Candidates Apply</h3>
                        <p>Invite candidates to complete the assessment via email or test links.</p>
                    </div>
                    </div>
                </li>
                <li class="step-item">
                    <div class="step-content-wrapper">
                    <span class="step-icon step-icon-xs step-icon-soft-danger">3</span>
                    <div class="step-content">
                        <h3 class="h4">Run Pre-assessment</h3>
                        <p>Receive real time notifications and shortlisted qualified candidates.</p>
                    </div>
                    </div>
                </li>
                <li class="step-item mb-0">
                    <div class="step-content-wrapper">
                    <span class="step-icon step-icon-xs step-icon-soft-danger">4</span>
                    <div class="step-content">
                        <h4>Shortlisted candidates</h4>
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
       <!-- Icon Blocks Section -->
        <div class="overflow-hidden">
          <div class="container space-2 space-top-lg-2 position-relative">
            <!-- Title -->
            <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
              <h2>Features</h2>
            </div>
            <!-- End Title -->

            <div class="row text-md-left text-center">
              <div class="col-sm-4 mb-3 mb-sm-5">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid " src="{{ asset('assetsfront/xploreImages/regulation.svg')}}" alt="SVG">
                  </figure>
                  <h4>Define Rules</h4>
                  <p>Create a preset rules to filter, shortlist and process candidates for furthur rounds.</p>
                </div>
                <!-- End Icon Blocks -->
              </div>

              <div class="col-sm-4 mb-3 mb-sm-5">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/clickstream.svg')}}" alt="SVG">
                  </figure>
                  <h4>Applicant Analytics</h4>
                  <p>Our insightful analytics about the applicants make hiring more efficient and less stressful for you.</p>
                </div>
                <!-- End Icon Blocks -->
              </div>

              <div class="col-sm-4 mb-3 mb-sm-5">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/profile.svg')}}" alt="SVG">
                  </figure>
                  <h4>Applicant Data</h4>
                  <p>Remote screening and hiring become a breeze with the detailed data we provide on every applicant. </p>
                </div>
                <!-- End Icon Blocks -->
              </div>

              <div class="col-sm-4 mb-3 mb-sm-5 mb-sm-0">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/video-call.svg')}}" alt="SVG">
                  </figure>
                  <h4>Profile Video</h4>
                  <p>Viewing them, you can peek into the personality of your applicants and assess their confidence levels and communication skills.</p>
                </div>
                <!-- End Icon Blocks -->
              </div>

              <div class="col-sm-4 mb-3 mb-sm-0">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/smart.svg')}}" alt="SVG">
                  </figure>
                  <h4>Shortlisting tools</h4>
                  <p>With this tool, you can easily weed out the candidates from your list who do not fit in with your requirements.</p>
                </div>
                <!-- End Icon Blocks -->
              </div>

              <div class="col-sm-4">
                <!-- Icon Blocks -->
                <div class="pr-lg-6">
                  <figure class="max-w-7rem w-100 mb-3 mx-auto mx-md-0">
                    <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/xls.svg')}}" alt="SVG">
                  </figure>
                  <h4>Excel Download</h4>
                  <p>Get all the important information about the candidates in excel with a single click.</p>
                </div>
                <!-- End Icon Blocks -->
              </div>
            </div>

            <!-- SVG Shapes -->
            <figure class="position-absolute z-index-n1" style="top: -35rem; left: 50rem; width: 62rem; height: 62rem;">
              <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 260 260">
                <circle fill="#e7eaf3" opacity=".7" cx="130" cy="130" r="130"/>
              </svg>
            </figure>
            <!-- End SVG Shapes -->
          </div>
        </div>
        <!-- End Icon Blocks Section -->
        
        <!-- Icon Blocks Section -->
        <div class="bg-light">
        <div class="container space-2 ">
            <h2 class="mb-2 text-center">Why Xplore ?</h2>
            <div class="mx-auto mb-8"><p class=" text-center w-75 mx-auto">Do you want to find the right candidates for your organization in minutes?
Then, Xplore’s job board, with its amazing features, is the platform you need.
</p></div>
        <div class="row justify-content-lg-center pl-1 pl-md-0">
            <div class="col-md-6 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/training.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Easy to use</h4>
                <p>The platform is aesthetically designed and is user friendly. It gives you an optimal viewing experience and facilitates easy reading and navigation. You can easily resize, scroll, and move across the screen whether you use a mobile or a laptop. </p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6  mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/computer-screen.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Fully Secure</h4>
                <p>We know that the personal data of candidates need the best protection possible. Our platform has advanced security features that make any kind of data leaks impossible.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="w-100"></div>

            <div class="col-md-6  mb-3 mb-md-7 ">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/target.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Pre-screened Profiles</h4>
                <p>We are aware of how your time is very valuable to you. By pre-screening every candidate, we make your hiring process easier, enabling you to save a lot of precious time and effort.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/network.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Vast Networks</h4>
                <p>Whatever data is posted on our platform has gone through extensive research to meet the needs of the market. Our vast network with all the top colleges in the country helps you find the best candidates for your organization.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

             <div class="w-100"></div>

            <div class="col-md-6  mb-3 mb-md-6">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/steps.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Transperant Process</h4>
                <p>We assure you that the data you will find on our platform is 100% reliable and genuine. All information we receive is thoroughly validated before it is posted on the platform.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6  mb-3 mb-md-6">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/call-center-agent.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Dedicated Support</h4>
                <p>Our friendly customer service team is always eager to provide all the help you need anytime. We will be most happy to resolve any issues you may encounter and make the screening and hiring process easy for you.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>
        </div>
        </div>
        </div>
        <!-- End Icon Blocks Section -->
   
    <!-- CTA Section -->
    <div class="container space-1 mb-2">
      <div class="text-center py-6"
        style="background: url({{ asset('assetsfront/svg/components/abstract-shapes-19.svg')}}) center no-repeat;">
        <h2 style="z-index: 10;">Hire the best.<br class="responsive" /> Faster.Easier</h2>
        <!-- <p>Test drive our use-friendly assessment platform.</p> -->
        <span class=" button d-block mt-5">
          <a class=" corporates_btn2  transition-3d-hover" href="contact">Try for free</a>
        </span>
      </div>
    </div>
    <!-- End CTA Section -->
    
  </main>
  <!-- ========== END MAIN ========== -->


  @include('appl.pages.xp.snippets.footermenu')
@include('appl.pages.xp.snippets.footer')