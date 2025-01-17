@extends('piofx.head')
@section('content-main')
       <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main" class="mt-5">
    <!-- Hero Section -->
    <div class="overflow-hidden">
      <div class="container space-top-1 space-top-md-2 space-bottom-3">
        <div class="row justify-content-lg-between align-items-md-center">
          <div class="col-md-6 col-lg-5 mb-7 mb-md-0">
            <div class="mb-5">
              <span class="d-block small font-weight-bold text-cap mb-2">For Institutes</span>
              <h1 class="display-4 mb-3">The OET Material that drives revenue  </h1>
              <p class="lead">Higher Scores, Happier Students,<br> Zero Setup Cost</p>
            </div>
            <a class="js-go-to position-static btn btn-primary btn-wide transition-3d-hover" href="javascript:;"
               data-hs-go-to-options='{
                "targetSelector": "#caseStudies",
                "offsetTop": 0,
                "position": null,
                "animationIn": false,
                "animationOut": false
               }'>
              Case Studies
            </a>
            <a class="btn btn-link btn-wide" href="#">Learn More <i class="fas fa-angle-right fa-sm ml-1"></i></a>
          </div>

          <div class="col-md-6">
            <div class="position-relative">
              <img class="img-fluid rounded" src="{{ asset('assetsfront/img/oet.jpg') }}" alt="Image Description">
              <div class="position-absolute top-0 right-0 w-100 h-100 bg-soft-primary rounded z-index-n1 mt-5 mr-n5"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Hero Section -->

    <!-- Clients Section -->
    <div class="container">
      <div class="js-slick-carousel slick"
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
             }, {
               "breakpoint": 480,
               "settings": {
                 "slidesToShow": 2
               }
             }]
           }'>
        <div class="js-slide">
          <img class="clients px-1" src="{{ asset('assetfront/svg/clients-logo/weebly-dark.svg')}}" alt="Image Description">
        </div>
        <div class="js-slide">
          <img class="clients px-1" src="{{ asset('assetfront/svg/clients-logo/uber-orignial.svg')}}" alt="Image Description">
        </div>
        <div class="js-slide">
          <img class="clients px-1" src="{{ asset('assetfront/svg/clients-logo/slack-dark.svg')}}" alt="Image Description">
        </div>
        <div class="js-slide">
          <img class="clients px-1" src="{{ asset('assetfront/svg/clients-logo/airbnb-dark.svg')}}" alt="Image Description">
        </div>
        <div class="js-slide">
          <img class="clients px-1" src="{{ asset('assetfront/svg/clients-logo/spotify-dark.svg')}}" alt="Image Description">
        </div>
      </div>
    </div>
    <!-- End Clients Section -->

    <!-- Portfolio Section -->
    <div id="caseStudies" class="container space-2 space-lg-3">
      <!-- Card -->
      <div data-aos="fade-up">
        <a class="card shadow-none bg-soft-success text-inherit transition-3d-hover p-4 p-md-7 mb-3 mb-md-11" href="#">
          <div class="row">
            <div class="col-lg-4 order-lg-2 mb-5 mb-lg-0">
              <div class="d-flex flex-column h-100">
                <div class="mb-7">
                  <h2 class="h1">Hubble</h2>
                  <p class="text-body">The more affordable daily contact lens. Modify or cancel anytime.</p>
                </div>

                <!-- Testimonials -->
                <div class="card shadow-none p-4 mt-auto">
                  <div class="mb-3">
                    <img class="clients mr-auto" src="../../assets/svg/clients-logo/fitbit-original.svg" alt="SVG Logo">
                  </div>

                  <div class="mb-3">
                    <blockquote class="text-dark">"The template is really nice and offers quite a large set of options. It's beautiful and the coding is done quickly and seamlessly. Thank you!"</blockquote>
                  </div>

                  <div class="media">
                    <div class="avatar avatar-circle mr-3">
                      <img class="avatar-img" src="../../assets/img/100x100/img3.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 mb-0">Max</span>
                      <small class="d-block text-muted">Fitbit Agency Partner</small>
                    </div>
                  </div>
                </div>
                <!-- End Testimonials -->
              </div>
            </div>

            <div class="col-lg-8 order-lg-1">
              <!-- Info -->
              <div class="mb-5">
                <img class="img-fluid rounded" src="../../assets/img/900x450/img15.jpg" alt="Image Description">
              </div>

              <div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <h4>Support and win</h4>
                  <p class="text-body">When we empower others to succeed, we all win. (And we're not talking about participation trophies.)</p>
                </div>

                <div class="col-sm-6">
                  <h4>Open communication</h4>
                  <p class="text-body">We're big fans of transparency for many reasons, but the abridged version is: it makes easier.</p>
                </div>
              </div>
              <!-- End Info -->
            </div>
          </div>
        </a>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div data-aos="fade-up">
        <a class="card shadow-none bg-soft-danger text-inherit transition-3d-hover p-4 p-md-7 mb-3 mb-md-11" href="#">
          <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0">
              <div class="d-flex flex-column h-100">
                <div class="mb-7">
                  <h2 class="h1">Curology</h2>
                  <p class="text-body">For healthy and beautiful skin, get skincare customized just for you from experts at Curology.</p>
                </div>

                <!-- Testimonials -->
                <div class="card shadow-none p-4 mt-auto">
                  <div class="mb-3">
                    <img class="clients mr-auto" src="../../assets/svg/clients-logo/airbnb-original.svg" alt="SVG Logo">
                  </div>

                  <div class="mb-3">
                    <blockquote class="text-dark">"I am absolutely floored by the level of care and attention to detail the team at Htmlstream have put into this theme and for one can guarantee that I will be a return customer."</blockquote>
                  </div>

                  <div class="media">
                    <div class="avatar avatar-circle mr-3">
                      <img class="avatar-img" src="../../assets/img/100x100/img10.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 mb-0">Luisa</span>
                      <small class="d-block text-muted">Executive Creative Director</small>
                    </div>
                  </div>
                </div>
                <!-- End Testimonials -->
              </div>
            </div>

            <div class="col-lg-8">
              <!-- Info -->
              <div class="mb-5">
                <img class="img-fluid rounded" src="../../assets/img/900x450/img16.jpg" alt="Image Description">
              </div>

              <div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <h4>Hit heavy, stay small</h4>
                  <p class="text-body">Tight-knit, dynamic teams work with more agility, communication, and freedom than large-scale companies.</p>
                </div>

                <div class="col-sm-6">
                  <h4>Ambition by the boatload</h4>
                  <p class="text-body">We love people who aim for greatness. They inspire and excite their teammates, raising the bar for all of us.</p>
                </div>
              </div>
              <!-- End Info -->
            </div>
          </div>
        </a>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div data-aos="fade-up">
        <a class="card shadow-none bg-soft-warning text-inherit transition-3d-hover p-4 p-md-7" href="#">
          <div class="row">
            <div class="col-lg-4 order-lg-2 mb-5 mb-lg-0">
              <div class="d-flex flex-column h-100">
                <div class="mb-7">
                  <h2 class="h1">Larq</h2>
                  <p class="text-body">LARQ Bottle Benefit Edition. 0. Lives will be saved with access. to clean water.</p>
                </div>

                <!-- Testimonials -->
                <div class="card shadow-none p-4 mt-auto">
                  <div class="mb-3">
                    <img class="clients mr-auto" src="../../assets/svg/clients-logo/slack-original.svg" alt="SVG Logo">
                  </div>

                  <div class="mb-3">
                    <blockquote class="text-dark">"It's a beautiful looking theme with great support from the developers. The included demos are a great way to understand the theme, its features and speed up development."</blockquote>
                  </div>

                  <div class="media">
                    <div class="avatar avatar-circle mr-3">
                      <img class="avatar-img" src="../../assets/img/100x100/img2.jpg" alt="Image Description">
                    </div>
                    <div class="media-body">
                      <span class="d-block h5 mb-0">Christina</span>
                      <small class="d-block text-muted">Head of Commercials</small>
                    </div>
                  </div>
                </div>
                <!-- End Testimonials -->
              </div>
            </div>

            <div class="col-lg-8 order-lg-1">
              <!-- Info -->
              <div class="mb-5">
                <img class="img-fluid rounded" src="../../assets/img/900x450/img17.jpg" alt="Image Description">
              </div>

              <div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <h4>Autonomy and attitude</h4>
                  <p class="text-body">We're a team of self-starters who take serious pride in our work – and it shows.</p>
                </div>

                <div class="col-sm-6">
                  <h4>Teamwork makes the dream work</h4>
                  <p class="text-body">We work together to bring our passions and expertise to make Teachable the best it can be.</p>
                </div>
              </div>
              <!-- End Info -->
            </div>
          </div>
        </a>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Portfolio Section -->

    <!-- Signup Form Section -->
    <div class="bg-navy rounded mx-3 mx-xl-10" style="background-image: url(../../assets/svg/components/abstract-shapes-20.svg);">
      <div class="container-xl container-fluid space-1 space-md-2 px-4 px-md-8 px-lg-10">
        <div class="row justify-content-lg-between align-items-lg-center">
          <div class="col-md-10 col-lg-5 mb-9 mb-lg-0">
            <h1 class="text-white">Hire us</h1>
            <p class="text-white-70">Whatever your goal - we will get your there.</p>

            <div class="w-50">
              <hr class="opacity-xs my-5">
            </div>

            <!-- Carousel Main -->
            <div id="testimonialsNavMain" class="js-slick-carousel slick mb-4"
                 data-hs-slick-carousel-options='{
                   "autoplay": true,
                   "autoplaySpeed": 5000,
                   "fade": true,
                   "infinite": true,
                   "asNavFor": "#testimonialsNavPagination"
                 }'>
              <div class="js-slide">
                <blockquote class="h3 text-white font-weight-normal mb-4"><em>"The template is really nice and offers quite a large set of options. Thank you!"</em></blockquote>
                <span class="h5 text-white">Christina Kray</span>
                <small class="d-block text-white-70">Social Media Executive, Airbnb</small>
              </div>

              <div class="js-slide">
                <blockquote class="h3 text-white font-weight-normal mb-4"><em>"It's beautiful and the coding is done quickly and seamlessly. Keep it up!"</em></blockquote>
                <span class="h5 text-white">James Austin</span>
                <small class="d-block text-white-70">Executive Creative Director, HubSpot</small>
              </div>

              <div class="js-slide">
                <blockquote class="h3 text-white font-weight-normal mb-4"><em>"I love Front! I love the ease of use, I love the fact that I have total creative freedom..."</em></blockquote>
                <span class="h5 text-white">Charlotte Moore</span>
                <small class="d-block text-white-70">Head of Commercials, Slack</small>
              </div>
            </div>
            <!-- End Carousel Main -->

            <!-- Carousel Pagination -->
            <div id="testimonialsNavPagination" class="js-slick-carousel slick slick-transform-off slick-pagination-modern"
                 data-hs-slick-carousel-options='{
                   "infinite": true,
                   "slidesToShow": 3,
                   "centerMode": true,
                   "isThumbs": true,
                   "asNavFor": "#testimonialsNavMain"
                 }'>
              <div class="js-slide">
                <div class="avatar avatar-circle">
                  <img class="avatar-img" src="../../assets/img/100x100/img1.jpg" alt="Image Description">
                </div>
              </div>

              <div class="js-slide">
                <div class="avatar avatar-circle">
                  <img class="avatar-img" src="../../assets/img/100x100/img3.jpg" alt="Image Description">
                </div>
              </div>

              <div class="js-slide">
                <div class="avatar avatar-circle">
                  <img class="avatar-img" src="../../assets/img/100x100/img2.jpg" alt="Image Description">
                </div>
              </div>
            </div>
            <!-- End Carousel Pagination -->
          </div>

          <div class="col-lg-6">
            <!-- Form -->
            <form class="js-validate card shadow-lg">
              <div class="card-body p-4 p-md-7">
                <div class="mb-4">
                  <h3>Fill out the form and we'll be in touch as soon as possible.</h3>
                </div>

                <div class="row mx-n2">
                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="firstName">First name</label>
                      <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First name" aria-label="First name" required
                             data-msg="Please enter first your name">
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="lastName">Last name</label>
                      <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last name" aria-label="Last name" required
                             data-msg="Please enter last your name">
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="workEmailAddress">Work email</label>
                      <input type="email" class="form-control" name="workEmailAddress" id="workEmailAddress" placeholder="Work email" aria-label="Work email" required
                             data-msg="Please enter a valid email address">
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="companyWebsite">Company website <span class="text-muted font-weight-normal ml-1">(optional)</span></label>
                      <input type="text" class="form-control" name="companyWebsite" id="companyWebsite" placeholder="Company website" aria-label="Company website"
                             data-msg="Please enter company website.">
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="budget">Budget</label>
                      <select class="form-control custom-select" name="budget" id="budget" required
                              data-msg="Please select your budget.">
                        <option value="" selected disabled>Budget</option>
                        <option value="budget1">None, just getting started</option>
                        <option value="budget1">Less than $20,000</option>
                        <option value="budget1">$20,000 to $50,000</option>
                        <option value="budget1">$50,000 to $100,000</option>
                        <option value="budget2">$100,000 to $500,000</option>
                        <option value="budget3">More than $500,000</option>
                      </select>
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-6 px-2">
                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="country">Country</label>
                      <select class="form-control custom-select" name="country" id="country" required
                              data-msg="Please select your country.">
                        <option value="" selected disabled>Country</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AX">Åland Islands</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctica</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia, Plurinational State of</option>
                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BV">Bouvet Island</option>
                        <option value="BR">Brazil</option>
                        <option value="IO">British Indian Ocean Territory</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CG">Congo</option>
                        <option value="CD">Congo, the Democratic Republic of the</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">Côte d'Ivoire</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CW">Curaçao</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="TF">French Southern Territories</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GG">Guernsey</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HM">Heard Island and McDonald Islands</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran, Islamic Republic of</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JE">Jersey</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea, Democratic People's Republic of</option>
                        <option value="KR">Korea, Republic of</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyzstan</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macao</option>
                        <option value="MK">Macedonia, the former Yugoslav Republic of</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia, Federated States of</option>
                        <option value="MD">Moldova, Republic of</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="ME">Montenegro</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PS">Palestinian Territory, Occupied</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RE">Réunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="BL">Saint Barthélemy</option>
                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                        <option value="KN">Saint Kitts and Nevis</option>
                        <option value="LC">Saint Lucia</option>
                        <option value="MF">Saint Martin (French part)</option>
                        <option value="PM">Saint Pierre and Miquelon</option>
                        <option value="VC">Saint Vincent and the Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SX">Sint Maarten (Dutch part)</option>
                        <option value="SK">Slovakia</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                        <option value="SS">South Sudan</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard and Jan Mayen</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan, Province of China</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania, United Republic of</option>
                        <option value="TH">Thailand</option>
                        <option value="TL">Timor-Leste</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom</option>
                        <option value="US">United States</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela, Bolivarian Republic of</option>
                        <option value="VN">Viet Nam</option>
                        <option value="VG">Virgin Islands, British</option>
                        <option value="VI">Virgin Islands, U.S.</option>
                        <option value="WF">Wallis and Futuna</option>
                        <option value="EH">Western Sahara</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                      </select>
                    </div>
                    <!-- End Form Group -->
                  </div>

                  <div class="col-sm-12 px-2">
                    <!-- Input -->
                    <div class="js-form-message form-group">
                      <label class="sr-only" for="aboutProject">Tell us about your project</label>
                      <textarea class="form-control" rows="3" name="aboutProject" id="aboutProject" placeholder="Tell us more about your project, needs, and timeline." aria-label="Tell us more about your project, needs, and timeline." required
                                data-msg="Please enter a reason."></textarea>
                    </div>
                    <!-- End Input -->
                  </div>
                </div>

                <!-- Checkbox -->
                <div class="js-form-message mb-5">
                  <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                    <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" checked>
                    <label class="custom-control-label small" for="termsCheckbox">
                      Yes, I'd like to receive occasional marketing emails from Front. I have the right to opt out at any time. <a class="link-underline" href="../pages/privacy.html">View privacy policy.</a>
                    </label>
                  </div>
                </div>
                <!-- End Checkbox -->

                <button type="submit" class="btn btn-block btn-primary">Get Started</button>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
      </div>
    </div>
    <!-- End Signup Form Section -->
  </main>
  <!-- ========== END MAIN CONTENT ========== -->
@endsection   