 @if($questions->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">Ref#({{$questions->total()}})</th>
                <th scope="col">Question </th>
                <th scope="col">Level</th>
                <th scope="col">In Test</th>
              </tr>
            </thead>
            <tbody>
              @foreach($questions as $key=>$question)  
              <tr>
               
                <td>
                  @if(\request()->category_slug)
                  <a href=" {{ route('category.question',[$project->slug,\request()->category_slug,$question->id]) }} ">
                  @else
                  <a href=" {{ route('question.show',[$project->slug,$question->id]) }} ">
                  @endif
                  <div>
                    {!! $question->reference !!}
                  </div>
                  </a>
                </td>
                <td>
                  <div>
                    {!! $question->question !!}
                  </div>
                </td>
                <td>
                  @if($question->level )
                    <span class="badge 
                      @if($question->level==1)
                        badge-warning
                      @elseif($question->level==2)
                       badge-info
                      @else
                        badge-success
                      @endif">Level {{ $question->level }}
                    </span>
                  @endif
                  </td>
                  <td>
                    @if($question->intest)
                     <span class="badge badge-secondary"> YES</span>
                    @endif
                  </td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Questions Listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($questions->total() > config('global.no_of_records'))mt-3 @endif">
        {{$questions->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
