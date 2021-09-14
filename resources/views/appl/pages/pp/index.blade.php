@include('appl.pages.pp.snippets.header')
  @include('appl.pages.pp.snippets.topmenu')
  <!-- ========== MAIN ========== -->

<main class="container space-top-1">

  <div class="row mt-7">
    <div class="overflow-hidden">
  <div class="container space-top-1 space-top-md-2 space-bottom-3">
    <div class="row justify-content-lg-between align-items-md-center">
      <div class="col-md-6 col-lg-5 mb-7 mb-md-0">
        <div class="mb-5">
          <span class="d-block small font-weight-bold text-cap mb-2">The Best </span>
          <h1 class="display-4 mb-3">Study Material for Job Prep</h1>
          <p class="lead">TCS NQT, Wipro NTH, InfyTQ, Capgemini, Cognizant, Accenture, Tech Mahindra, Deloitte, HCL and more</p>
        </div>
         <a class="js-go-to position-static btn btn-primary btn-wide transition-3d-hover" href="/login"
           data-hs-go-to-options='{
            "targetSelector": "#caseStudies",
            "offsetTop": 0,
            "position": null,
            "animationIn": false,
            "animationOut": false
           }'>
          Login
        </a>
        <a class="btn btn-link btn-wide" href="/register">Register Now <i class="fas fa-angle-right fa-sm ml-1"></i></a>
      </div>


      <div class="col-md-6">
        <div class="position-relative">
          <img class="img-fluid rounded" src="https://i.imgur.com/PRC6pB9.jpg" alt="Image Description">
          <div class="position-absolute top-0 right-0 w-100 h-100 bg-soft-primary rounded z-index-n1 mt-5 mr-n5"></div>
        </div>
      </div>
    </div>
  </div>
</div>
  </div>
</main>

<div class="bg-soft-primary py-2">
  <div class="container">
  <div class="w-lg-75 mx-lg-auto mt-5 mb-5"><div class="media d-block d-sm-flex pt-4"><figure class="w-100 max-w-15rem mr-4 mb-3 mb-sm-0"><img class="img-fluid" src="https://tech.packetprep.com/themes/front/svg/illustrations/growing-business.svg" ></figure><div class="media-body"><h4>Listen to our students who got placed</h4><p>Our focus is on quality, consistency and success. If your target is cracking a job then in you are in the right place <a class="font-weight-bold" href="https://packetprep.com/testimonials">See our testimonials <i class="fas fa-angle-right ml-1"></i></a></p></div></div></div>

  </div>
</div>
<div class="bg-dark py-2">
  <div class="container py-3 text-light">
  &copy; PacketPrep | The Best preparation platform for campus placements
  <span class="float-right">+91 90000 45750</span>
  </div>
</div>



@include('appl.pages.pp.snippets.footer')