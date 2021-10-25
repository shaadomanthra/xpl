 @include('appl.pages.xp.snippets.header')
  @include('appl.pages.xp.snippets.topmenu')
 <!-- ========== MAIN ========== -->
  <main id="content" role="main" class="pt-9">
    <!-- Hero Section -->
        <div class="overflow-hidden">
        <div class="container space-top-2 space-top-md-3 space-bottom-md-3 space-bottom-2">
        <div class="row justify-content-lg-between align-items-md-center">
            <div class="col-md-6 col-lg-5 mb-7 mb-md-0 " data-aos="fade-right" data-aos-delay="900"   data-aos-duration="1000" >
            <div class="mb-5">
                <!-- <span class="d-block small font-weight-bold text-cap mb-2">Who we are?</span> -->
                <h1 class="display-4 mb-3">Xplore placement club</h1>
                <p class="lead">Join the club for exclusive placement drives, tech talks, premium learning content.</p>
            </div>
            <a class="js-go-to position-static btn btn-primary btn-wide transition-3d-hover" href="login"
                data-hs-go-to-options='{
                "targetSelector": "#caseStudies",
                "offsetTop": 0,
                "position": null,
                "animationIn": false,
                "animationOut": false
                }'>
                Join Now
                
            </a>
            <!-- <a class="btn btn-link btn-wide" href="#">Learn More <i class="fas fa-angle-right fa-sm ml-1"></i></a> -->
            </div>

            <div class="col-md-6">
            <div class="position-relative" data-aos="fade-left" data-aos-delay="900"  data-aos-duration="1000">
                <img class="img-fluid rounded" src="{{ asset('assetsfront/xploreImages/interview_hero.svg')}}" alt="Image Description">
                <!-- <div class="position-absolute top-0 right-0 w-100 h-100 bg-soft-primary rounded z-index-n1 mt-5 mr-n5"></div> -->
            </div>
            </div>
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
        </div>
        </div>
        <!-- End Clients Section -->

      <!-- Features Section -->
        <div class="container space-2">
        <div class="row justify-content-lg-between align-items-lg-center">
        <div class="col-lg-5 mb-9 mb-lg-0">
            <div class="mb-3">
            <h2 class="h1">One stop platform for preparation, exposure and placements.</h2>
            </div>

            <p> As an experienced staff recruitment company, we take care of all the placement needs of companies who can leverage our advanced smart platforms that make screening and hiring easier. We help you hire future-ready talent who meet your job requirements and also the ethos of your organization.</p><p> Whether niche positions or bulk hiring, we hunt the right talent for you in the shortest possible time.</p>

            <div class="mt-4">
            <a class="btn btn-primary btn-wide transition-3d-hover" href="/login">Start Now</a>
            </div>
        </div>

        <div class="col-lg-6 col-xl-5">
            <!-- SVG Element -->
            <div class="position-relative min-h-500rem mx-auto" style="max-width: 28rem;">
            <figure class="position-absolute top-0 right-0 z-index-2 mr-11">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 450 450" width="165" height="165">
                <g>
                    <defs>
                    <path id="circleImgID2" d="M225,448.7L225,448.7C101.4,448.7,1.3,348.5,1.3,225l0,0C1.2,101.4,101.4,1.3,225,1.3l0,0
                        c123.6,0,223.7,100.2,223.7,223.7l0,0C448.7,348.6,348.5,448.7,225,448.7z"/>
                    </defs>
                    <clipPath id="circleImgID1">
                    <use xlink:href="#circleImgID2"/>
                    </clipPath>
                    <g clip-path="url(#circleImgID1)">
                    <image width="450" height="450" xlink:href="{{ asset('assetsfront/img/450x450/img1.jpg')}}" ></image>
                    </g>
                </g>
                </svg>
            </figure>

            <figure class="position-absolute top-0 left-0">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 335.2 335.2" width="120" height="120">
                <circle fill="none" stroke="#377DFF" stroke-width="75" cx="167.6" cy="167.6" r="130.1"/>
                </svg>
            </figure>

            <figure class="d-none d-sm-block position-absolute top-0 left-0 mt-11">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 515 515" width="200" height="200">
                <g>
                    <defs>
                    <path id="circleImgID4" d="M260,515h-5C114.2,515,0,400.8,0,260v-5C0,114.2,114.2,0,255,0h5c140.8,0,255,114.2,255,255v5
                        C515,400.9,400.8,515,260,515z"/>
                    </defs>
                    <clipPath id="circleImgID3">
                    <use xlink:href="#circleImgID4"/>
                    </clipPath>
                    <g clip-path="url(#circleImgID3)">
                    <image width="515" height="515" xlink:href="{{ asset('assetsfront/img/515x515/img1.jpg')}}" transform="matrix(1 0 0 1 1.639390e-02 2.880859e-02)"></image>
                    </g>
                </g>
                </svg>
            </figure>

            <figure class="position-absolute top-0 right-0" style="margin-top: 11rem; margin-right: 13rem;">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 67 67" width="25" height="25">
                <circle fill="#00C9A7" cx="33.5" cy="33.5" r="33.5"/>
                </svg>
            </figure>

            <figure class="position-absolute top-0 right-0 mr-3" style="margin-top: 8rem;">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 141 141" width="50" height="50">
                <circle fill="#FFC107" cx="70.5" cy="70.5" r="70.5"/>
                </svg>
            </figure>

            <figure class="position-absolute bottom-0 right-0">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 770.4 770.4" width="280" height="280">
                <g>
                    <defs>
                    <path id="circleImgID6" d="M385.2,770.4L385.2,770.4c212.7,0,385.2-172.5,385.2-385.2l0,0C770.4,172.5,597.9,0,385.2,0l0,0
                        C172.5,0,0,172.5,0,385.2l0,0C0,597.9,172.4,770.4,385.2,770.4z"/>
                    </defs>
                    <clipPath id="circleImgID5">
                    <use xlink:href="#circleImgID6"/>
                    </clipPath>
                    <g clip-path="url(#circleImgID5)">
                    <image width="900" height="900" xlink:href="{{ asset('assetsfront/img/900x900/img2.jpg')}}" transform="matrix(1 0 0 1 -64.8123 -64.8055)"></image>
                    </g>
                </g>
                </svg>
            </figure>
            </div>
            <!-- End SVG Element -->
        </div>
        </div>
        </div>
        <!-- End Features Section -->    
        <!-- Icon Blocks Section -->
        <div class="bg-soft-danger">
        <div class="container space-2 ">
            <h2 class="mb-8 text-center">For Students</h2>
        <div class="row justify-content-lg-center">
            <div class="col-md-6 col-lg-5 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/reading.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>CONTENT</h4>
                <p>Exclusive video lessons 10000+ practice questions TCS, WIPRO, INFY material 40+ company mock tests.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6 col-lg-5 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/classroom.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>ONLINE TRAINING</h4>
                <p>Weekly live sessions unlimited asessments performance metrics.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="w-100"></div>

            <div class="col-md-6 col-lg-5 mb-3 mb-md-7 mb-lg-0">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/chat.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>ACTIVITES</h4>
                <p>Tech talks HR interactions industry panel discussions.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6 col-lg-5">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/interview.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>PLACEMENTS</h4>
                <p>Priority placement drives internships & projects job notifications.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>
        </div>
        </div>
        </div>
        <!-- End Icon Blocks Section -->
        <!-- Icon Blocks Section -->
        <div class="container space-1 ">
        <!-- Title -->
        <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
            <!-- <span class="d-block small font-weight-bold text-cap mb-2">Benefits</span> -->
            <h2 class="h2">For Colleges</h2>
        </div>
        <!-- End Title -->

        <div class="row">
            <div class="col-md-4 mb-5 mb-md-0">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
                <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/silver-cup.svg')}}" alt="SVG">
                </figure>
                <h3>Silver</h3>
                <p>- Performance metrics <br>- Placements opportunities <br>- Online CRT.</p>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-4 mb-5 mb-md-0">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
                <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/trophy.svg')}}" alt="SVG">
                </figure>
                <h3>Gold</h3>
                <p>-All silver benefits <br>- One company specific training <br>- One industry talk.</p>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-4">
            <!-- Icon Blocks -->
            <div class="text-center px-lg-3">
                <figure class="max-w-10rem mx-auto mb-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/vip.svg')}}" alt="SVG">
                </figure>
                <h3>VIP</h3>
                <p >- All gold benefits <br>- Xplore nodal center <br>- 2 VIP drives <br>- Free Eamcet mock test platform.</p>
            </div>
            <!-- End Icon Blocks -->
            </div>
        </div>
        </div>
        <!-- End Icon Blocks Section -->
        <!-- Icon Blocks Section -->
        <div class="bg-soft-danger">
        <div class="container space-2 ">
            <h2 class="mb-8 text-center">Why Xplore ?</h2>
        <div class="row justify-content-lg-center">
            <div class="col-md-6 col-lg-5 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/training.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Experienced Faculty</h4>
                <p>Trainers are well qualified with minimum 5 years experience.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6 col-lg-5 mb-3 mb-md-7">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/bookshelf.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Quality Material</h4>
                <p>Extensively researched content has been designed to suit the needs of the market.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="w-100"></div>

            <div class="col-md-6 col-lg-5 mb-3 mb-md-7 mb-lg-0">
            <!-- Icon Blocks -->
            <div class="media pr-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/certification.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Excellent Training</h4>
                <p>Industry best training to fill gap in engineering students.</p>
                </div>
            </div>
            <!-- End Icon Blocks -->
            </div>

            <div class="col-md-6 col-lg-5">
            <!-- Icon Blocks -->
            <div class="media pl-lg-5">
                <figure class="w-100 max-w-8rem mr-4">
                <img class="img-fluid" src="{{ asset('assetsfront/xploreImages/jigsaw.svg')}}" alt="SVG">
                </figure>
                <div class="media-body">
                <h4>Add-ons</h4>
                <p>- Discounts on special Training. <br>- Abroad study guidance <br>- Partner Coupons <br>- Startup Support</p>
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
        <h2>Find the right learning path for you</h2>
        <p>Answer a few questions and match your goals to our programs.</p>
        <span class=" button d-block mt-5">
          <a class=" corporates_btn2  transition-3d-hover" href="#">Start Now</a>
        </span>
      </div>
    </div>
    <!-- End CTA Section -->
    
  </main>
  <!-- ========== END MAIN ========== -->


@include('appl.pages.xp.snippets.footermenu')
@include('appl.pages.xp.snippets.footer')