 @include('appl.pages.xp.snippets.header')
  @include('appl.pages.xp.snippets.topmenu')

<!-- ========== MAIN ========== -->
  <main id="content" role="main" class="pt-md-8">
   <!-- Contact Form Section -->
<div class="container space-2">
  <div class="row">
    <div class="col-lg-6 mb-9 mb-lg-0">
      <div class="mb-5">
        <h1 class="display-4">Get in touch</h1>
        <p>We'd love to talk about how we can help you.</p>
      </div>

      <!-- Leaflet -->
     <iframe class="w-100 mb-4" height="300" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJRVrg9V6RyzsRfJ3Qw1idMCI&key=AIzaSyCdRZQkwLoQV_3BtOBWfJA93Thke_iza8Y" allowfullscreen></iframe>
      <!-- End Leaflet -->

      <div class="row">
        <div class="col-sm-6">
          <div class="mb-3">
            <span class="d-block h5 mb-1">Call us:</span>
            <span class="d-block text-body font-size-1">1800-890-1324</span>
          </div>

          <div class="mb-3">
            <span class="d-block h5 mb-1">Email us:</span>
            <span class="d-block text-body font-size-1"> info@xplore.co.in</span>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="mb-3">
            <span class="d-block h5 mb-1">Address:</span>
            <span class="d-block text-body font-size-1">  Xplore, 2nd floor, Oyester Uptown Building, Beside Durgam Cheruvu Metro Station, Madhapur, Hi-Tech City, 500081.</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
    	@include('flash::message')

      @if ($errors->any())
          <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)
                      {{ $error }}
                  @endforeach
            
          </div>
      @endif
      <div class="ml-lg-5">
        <!-- Form -->
        <form class="js-validate card shadow-lg mb-4" method="post" action="{{ route('contactform')}}">
          <div class="card-header border-0 bg-light text-center py-4 px-4 px-md-6">
            <h2 class="h4 mb-0">General Enquiries</h2>
          </div>

          <div class="card-body p-4 p-md-6">
            <div class="row">
              <div class="col-sm-6">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="firstNameExample1" class="input-label">Name</label>
                  <input type="text" class="form-control" name="name" id="firstNameExample1" placeholder="Full name" aria-label="Nataly" required
                         data-msg="Please enter your name">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-6">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="lastNameExample1" class="input-label">Phone</label>
                  <input type="text" class="form-control" name="phone" id="lastNameExample1" placeholder="Phone number" aria-label="Gaga" required
                         data-msg="Please enter phone number">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="emailAddressExample1" class="input-label">Email address</label>
                  <input type="email" class="form-control" name="email" id="emailAddressExample1" placeholder="your email id" aria-label="alex@pixeel.com" required
                         data-msg="Please enter a valid email address">
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="emailAddressExample1" class="input-label">I am a</label>
                  <select class="form-control" id="exampleFormControlSelect1" name="iama">
                    <option value="student">Student</option>
                    <option value="college">School/College Representative</option>
                    <option value="hr-manager">HR Manager</option>
                    <option value="business">Business</option>
                  </select>
                </div>
                <!-- End Form Group -->
              </div>

              <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label for="message" class="input-label">Message</label>
                  <div class="input-group">
                    <textarea class="form-control" rows="4" name="message" id="message" placeholder="Hi there, I would like to ..." aria-label="Hi there, I would like to ..." required
                              data-msg="Please enter a reason."></textarea>
                  </div>
                </div>
                <!-- End Form Group -->
              </div>


               <div class="col-sm-12">
                <!-- Form Group -->
                <div class="js-form-message form-group">
                   <div class="captcha">

                          <div class="h4 mb-2"> {{rand(4,5)}} + {{rand(2,3)}} = </div>


                          </div>

                          <input id="captcha" type="text" class="form-control" placeholder="Enter the summation" name="sum">

                          

                </div>
                <!-- End Form Group -->
              </div>

            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-block  transition-3d-hover" style="background-color: #e24d4b; color: #fff;">Submit</button>
          </div>
        </form>
        <!-- End Form -->

        <div class="text-center">
          <p class="small">We'll get back to you in 1-2 business days.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Contact Form Section -->
 
  </main>
  <!-- ========== END MAIN ========== -->

  @include('appl.pages.xp.snippets.footermenu')
@include('appl.pages.xp.snippets.footer')