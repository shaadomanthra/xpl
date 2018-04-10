@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('system')}}">System</a></li>
    <li class="breadcrumb-item " ><a href="{{ route('update.index')}}">Updates</a></li>
    <li class="breadcrumb-item active" aria-current="page">#{{ $update->id }}</li>
  </ol>
</nav>
<div  class="row mt-4">
  <div class="col-md-12">

    @include('flash::message')  
    
            <div class="row  mb-md-0">
              <div class="col-12 col-md-2 text-right d-none d-md-block">
                <img class="img-thumbnail  mb-3"src="{{ Gravatar::src($update->user->email, 120) }}"><br>
                <a href="{{ route('profile','@'.\auth::user()->getUsername($update->user_id))}}">
                	<h3 class="mb-0 p-0">{{ \auth::user()->getName($update->user_id)}}</h3></a><br>
                <div>{{ \auth::user()->getDesignation($update->user_id)}}</div>
                <small class="text-secondary mb-4">{{ $update->created_at->diffForHumans() }}</small>
                @can('edit',$update)
                  <div class="mt-2 mb-4">
                  <button class="btn btn-sm btn-outline-secondary mb-1" disabled>
                  @if($update->status==0)
                  Draft
                  @else
                  Published
                  @endif
                  </button>
                  <a href="{{ route('update.edit',$update->id) }}">
                  <button class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i> edit</button>
                  </a>
                  </div>
                @endcan
              </div>
              <div class="col-12 col-md-10">
                <div class="bg-white border p-4">
                <div class="mb-3">

                <div class=" d-block d-md-none ">
                <a href="{{ route('profile','@'.\auth::user()->getUsername($update->user_id))}}">
                  <h3 class="mb-0 p-0">{{ \auth::user()->getName($update->user_id)}}</h3></a><br>
                </div>	

                @if($update->type==2)
                <div class="text-success rounded mb-3">
                  <h2 class="mb-0"><i class="fa fa-trophy text-success"></i> Milestone</h2>
                </div>
                <h1>
                @endif

                {!! $update->content !!}
                @if($update->type==2)
                </h1>
                @endif
                </div>
                


                </div>

                <div class="comment bg-light border p-3 ">
              	<div id="disqus_thread"></div>
				<script>

				/**
				*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
				*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
				/*
				var disqus_config = function () {
				this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
				this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
				};
				*/
				(function() { // DON'T EDIT BELOW THIS LINE
				var d = document, s = d.createElement('script');
				s.src = 'https://team-packetprep.disqus.com/embed.js';
				s.setAttribute('data-timestamp', +new Date());
				(d.head || d.body).appendChild(s);
				})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
              </div>
              </div>


            </div>
         
        </div>

</div>
@endsection
