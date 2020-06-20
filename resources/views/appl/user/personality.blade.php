
@if(\Auth::user())
@if(\Auth::user()->checkRole(['administrator','manager','investor','patron','promoter','employee','hr-manager']))

@if($user->personality)
<h2 class="ml-4 mt-4"><i class="fa fa-gg"></i> Personality Grading</h2>
<div class="row mb-3 mr-2 ml-2 mt-4">

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #f9e2df;border-left:5px solid #ed443c;background: #fdf5f4">
      <h3 class="display-5">Grade</h3>
      <h5 class="heading_one" style="color:#ed443c;opacity: 0.7">@if($user->personality>=8)
        A
      @elseif($user->personality>=5 && $user->personality<8)
        B
      @elseif($user->personality>=2 && $user->personality<5)
        C 
      @else
        -

      @endif</h5>
    </div>
  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #f5e2e5;border-left:5px solid #bf4a60;background: #ffedf0">
      <h3 class="display-5">Language</h3>
      <h5 class="heading_one" style="color:#bf4a60;opacity: 0.7">@if($user->language)
            {{$user->language}}
          @else
            -
          @endif</h5>
    </div>
    
  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="border:1px solid #eee1f5;border-left:5px solid #7e4f8d;background:  #fbf3ff;">
      <h3 class="display-5">Confidence</h3>
      <h5 class="heading_one" style="color:#7e4f8d;opacity: 0.7">@if($user->confidence)
            @if($user->confidence<10)
            {{$user->confidence}}
            @else
              -
            @endif
          @else
            -
          @endif</h5>
    </div>

  </div>

  <div class="col-12 col-md-3">
    <div class="p-3 mb-3" style="background: #f5f3ff;border:1px solid #e6e2ff;border-left:5px solid #5950a4;">
      <h3 class="display-5">Fluency</h3>
      <h5 class="heading_one" style="color:#5950a4;opacity: 0.7"> @if($user->fluency)
            {{$user->fluency}}
          @else
            -
          @endif</h5>
    </div>
    
  </div>


</div>
@endif

@endif