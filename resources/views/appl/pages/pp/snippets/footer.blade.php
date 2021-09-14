  <!-- JS Global Compulsory -->
  <script src="{{ asset('assetsfront/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

  <!-- JS Implementing Plugins -->
  <script src="{{ asset('assetsfront/vendor/hs-header/dist/hs-header.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/hs-go-to/dist/hs-go-to.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/hs-unfold/dist/hs-unfold.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/hs-mega-menu/dist/hs-mega-menu.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/hs-show-animation/dist/hs-show-animation.min.js')}}"></script>
  <script src="{{ asset('assetsfront/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>

  <script src="{{ asset('assetsfront/vendor/dzsparallaxer/dzsparallaxer.js')}}"></script>

  <!-- JS Front -->
  <script src="{{ asset('assetsfront/js/hs.core.js')}}"></script>
  <script src="{{ asset('assetsfront/js/hs.validation.js')}}"></script>
  <!-- JS Implementing Plugins -->
<script src="{{ asset('assetsfront/vendor/slick-carousel/slick/slick.js')}}"></script>

<!-- JS Front -->
<script src="{{ asset('assetsfront/js/hs.slick-carousel.js')}}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
    // initialization of slick carousel
    $('.js-slick-carousel').each(function() {
      var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
    });
  });
</script>
<!-- JS Implementing Plugins -->
<script src="{{ asset('assetsfront/vendor/hs-counter/dist/hs-counter.min.js')}}"></script>
<script src="{{ asset('assetsfront/vendor/appear.js')}}"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
    // initialization of counter
    $('.js-counter').each(function() {
      var counter = new HSCounter($(this)).init();
    });
  });
</script>

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

      // initialization of show animations
      $('.js-animation-link').each(function () {
        var showAnimation = new HSShowAnimation($(this)).init();
      });

      // initialization of form validation
      $('.js-validate').each(function () {
        $.HSCore.components.HSValidation.init($(this), {
          rules: {
            confirmPassword: {
              equalTo: '#signupPassword'
            }
          }
        });
      });

      // initialization of go to
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>
     <script>
       AOS.init();
    </script>

  <!-- IE Support -->
  <script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{ asset("assetsfront/vendor/polifills.js")}}") }}"><\/script>');
  </script>
</body>

</html>