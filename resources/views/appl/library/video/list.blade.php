 @if($videos->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$videos->total()}})</th>
                <th scope="col">Video </th>
                <th scope="col">Creator </th>
                <th scope="col">Lesson </th>
                <th scope="col">Created at</th>
              </tr>
            </thead>
            <tbody>
              @foreach($videos as $key=>$video)  
              <tr>
                <th scope="row">{{ $videos->currentpage() ? ($videos->currentpage()-1) * $videos->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('video.show',[$repo->slug,$video->id]) }} ">
                  {{ $video->name }}
                  </a><br>
                  <img src="{{ $video->getThumbnail($video->video)}}"  style="width:100px"/>
                </td>
                <td><a href="{{ route('profile','@'.$video->user->username) }}">{{ $video->user->name }}</a></td>
                <td>{{ $video->structure->name }}</td>
                <td>{{ ($video->created_at) ? $video->created_at->diffForHumans() : '' }}</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No videos Listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($videos->total() > config('global.no_of_records'))mt-3 @endif">
        {{$videos->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
