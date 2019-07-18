 @if($forms->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$forms->total()}})</th>
                <th scope="col">Name</th>
                <th scope="col">College</th>
                <th scope="col">Branch</th>
                <th scope="col">Applied for</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($forms as $key=>$form)  
              <tr>
                <th scope="row">{{ $forms->currentpage() ? ($forms->currentpage()-1) * $forms->perpage() + ( $key + 1) : $key+1 }}</th>
                <td>
                  <a href=" {{ route('form.show',$form->id) }} ">
                  {{ $form->name }}
                  </a>
                  @if($form->user)
                  @foreach($form->user->roles()->get() as $k=> $r)
                  <span class="badge @if($r->name=='Campus Ambassador') badge-warning @else badge-secondary @endif">{{ $r->name }}</span><br>
                  @endforeach
                  @endif
                </td>
                <td>{{ ($form->college)? ($form->college) : '-' }}<br>
                  @if($form->user->details()->first())
                    @if($form->user->details()->first()->year_of_passing != '2020' )
                      <span class="badge badge-info">{{ $form->user->details()->first()->year_of_passing }}</span>
                    @else
                      {{ $form->user->details()->first()->year_of_passing }}
                    @endif
                  @else

                  @endif 
                </td>
                 <td>{{ ($form->branch)? ($form->branch) : '-' }}</td>
               
                <td>{{ $form->job->title }}</td>
                <td>@if($form->status==0) <span class="badge badge-secondary">Open</span> @elseif($form->status==1) <span class="badge badge-success">Accepted</span>@else <span class="badge badge-danger">Rejected</span> @endif</td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Forms listed
        </div>
        @endif
        <nav aria-label="Page navigation  " class="card-nav @if($forms->total() > config('global.no_of_records'))mt-3 @endif">
        {{$forms->appends(request()->except(['page','search']))->links('vendor.pagination.bootstrap-4') }}
      </nav>
