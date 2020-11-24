<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Title -->
        <title>PiofX</title>
        <!-- Required Meta Tags Always Come First -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="shortcut icon" href="favicon_piofx.ico">
        <!-- Font -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap" rel="stylesheet">
        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{ asset('assetsfront/vendor/font-awesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/cubeportfolio/css/cubeportfolio.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/front.css') }}">
        <!-- CSS Front Template -->
        <link rel="stylesheet" href="{{ asset('assetsfront/css/theme.css') }}">

    </head>
    <body>
        <!-- ========== HEADER ========== -->
          <header id="header" class="header center-aligned-navbar header-bg-transparent @if(!isset($menudark)) header-white-nav-links-lg @endif header-abs-top" data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'>
            <div class="header-section">
                <div id="logoAndNav" class="container">
                  @include('piofx.topmenu')
                </div>
            </div>
        </header>
        <!-- ========== END HEADER ========== -->
       
         @yield('content-main')

        <!-- ========== FOOTER ========== -->
        <footer class="bg-dark">
            <div class="container">
                <div class="space-top-2 space-bottom-1 space-bottom-lg-2">
                    <div class="row justify-content-lg-between">
                        <div class="col-lg-3 ml-lg-auto mb-5 mb-lg-0">
                            <!-- Logo -->
                            <div class="mb-4">
                                <h1 class="text-white">PiofX</h1>
                            </div>
                            <!-- End Logo -->
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
                                <li class="nav-item">
                                    <a class="nav-link media" href="javascript:;"> <span class="media-body">
                      Platinum Partner - British Council. The most awarded training institute in South India. The most awesome classes on this side of the solar system. </span> </span> </a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                        <div class="col-6 col-md-3 col-lg mb-5 mb-lg-0">
                            <h5 class="text-white">Company</h5>
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Careers <span class="badge badge-primary ml-1">We're hiring</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Customers</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Hire us</a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                        <div class="col-6 col-md-3 col-lg mb-5 mb-lg-0">
                            <h5 class="text-white">Features</h5>
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Press</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Release notes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Integrations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Pricing</a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                        <div class="col-6 col-md-3 col-lg">
                            <h5 class="text-white">Documentation</h5>
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Support</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Docs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Status</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">API Reference</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Tech Requirements</a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                        <div class="col-6 col-md-3 col-lg">
                            <h5 class="text-white">Resources</h5>
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-x-0 nav-white flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> <span class="media align-items-center"> <i class="fa fa-info-circle mr-2"></i> <span class="media-body">Help</span> </span> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"> <span class="media align-items-center"> <i class="fa fa-user-circle mr-2"></i> <span class="media-body">Your Account</span> </span> </a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                    </div>
                </div>
                <hr class="opacity-xs my-0">
                <div class="space-1">
                    <div class="row align-items-md-center mb-7">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <!-- Nav Link -->
                            <ul class="nav nav-sm nav-white nav-x-sm align-items-center">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Privacy &amp; Policy</a>
                                </li>
                                <li class="nav-item opacity mx-3">&#47;</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Terms</a>
                                </li>
                                <li class="nav-item opacity mx-3">&#47;</li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Contact</a>
                                </li>
                            </ul>
                            <!-- End Nav Link -->
                        </div>
                        <div class="col-md-6 text-md-right">
                            <ul class="list-inline mb-0">
                                <!-- Social Networks -->
                                <li class="list-inline-item">
                                    <a class="btn btn-xs btn-icon btn-soft-light" href="#"> <i class="fab fa-facebook-f"></i> </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn btn-xs btn-icon btn-soft-light" href="#"> <i class="fab fa-google"></i> </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn btn-xs btn-icon btn-soft-light" href="#"> <i class="fab fa-twitter"></i> </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="btn btn-xs btn-icon btn-soft-light" href="#"> <i class="fab fa-github"></i> </a>
                                </li>
                                <!-- End Social Networks -->
                                
                            </ul>
                        </div>
                    </div>
                    <!-- Copyright -->
                    <div class="w-md-75 text-lg-center mx-lg-auto">
                        <p class="text-white opacity-sm small">&copy; Piofx Media Private Limited. 2020. All rights reserved.</p>
                        <p class="text-white opacity-sm small">When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.</p>
                    </div>
                    <!-- End Copyright -->
                </div>
            </div>
        </footer>
        <!-- ========== END FOOTER ========== -->
        <!-- Go to Top -->
        <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;" data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
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
     }'> <i class="fas fa-angle-up"></i> </a>
        <!-- End Go to Top -->
        <!-- JS Global Compulsory -->
        <script src="../../assetsfront/vendor/jquery/dist/jquery.min.js"></script>
        <script src="../../assetsfront/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
        <script src="../../assetsfront/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- JS Implementing Plugins -->
        <script src="../../assetsfront/vendor/hs-header/dist/hs-header.min.js"></script>
        <script src="../../assetsfront/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
        <script src="../../assetsfront/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
        <script src="../../assetsfront/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
        <script src="../../assetsfront/vendor/fancybox/dist/jquery.fancybox.min.js"></script>
        <script src="../../assetsfront/vendor/appear.js"></script>
        <script src="../../assetsfront/vendor/circles/circles.min.js"></script>
        <script src="../../assetsfront/vendor/aos/dist/aos.js"></script>
        <!-- JS Front -->
        <script src="../../assetsfront/js/hs.core.js"></script>
        <script src="../../assetsfront/js/hs.fancybox.js"></script>
        <script src="../../assetsfront/js/hs.circles.js"></script>
        <!-- JS Plugins Init. -->
        <script>
    $(document).on('ready', function () {
      // initialization of header
      var header = new HSHeader($('#header')).init();

      // initialization of mega menu
      var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
        desktop: {
          position: 'left'
        }
      }).init();

      // initialization of unfold
      var unfold = new HSUnfold('.js-hs-unfold-invoker').init();

      // initialization of fancybox
      $('.js-fancybox').each(function () {
        var fancybox = $.HSCore.components.HSFancyBox.init($(this));
      });

      // initialization of circles
      $('.js-circle').each(function () {
        var circle = $.HSCore.components.HSCircles.init($(this));
      });

      // initialization of aos
      AOS.init({
        duration: 650,
        once: true
      });

      // initialization of go to
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>
        <!-- IE Support -->
        <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="../../assetsfront/vendor/polifills.js"><\/script>');
  </script>
    </body>
</html>