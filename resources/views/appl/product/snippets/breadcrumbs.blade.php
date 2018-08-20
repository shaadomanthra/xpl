<nav aria-label="breadcrumb">
  <ol class="breadcrumb border">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    @if(request()->is('client'))
    <li class="breadcrumb-item " >Clients</li>
    @elseif(request()->is('client*'))
	<li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clients</a></li>
	<li class="breadcrumb-item" >{{ $stub }}</li>
    @endif
  </ol>
</nav>