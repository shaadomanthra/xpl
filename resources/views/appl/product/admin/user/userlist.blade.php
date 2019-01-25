@extends('layouts.plain')
@section('content')


<div  class="row ">
 @if($users->total()!=0)
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead>
              <tr>
                <th scope="col">#({{$users->total()}})</th>
                <th scope="col">Name </th>
                <th scope="col">Branch</th>
                <th scope="col">Service</th>
                <th scope="col">Amount</th>
                <th scope="col">Signature</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $key=>$user)  
              <tr>
                <th scope="row">{{ $key+1 }}</th>
                <td>
                  <a href=" {{ route('admin.user.view',$user->username) }} ">
                  {{ $user->name }}
                  </a>
                </td>
                <td>
                  @if($user->branches())
                  @foreach($user->branches()->get() as $branch)
                      {{ $branch->name}} &nbsp;
                  @endforeach
                  @endif
                </td>
                
                <td>
                  @if($user->services())
                @foreach($user->services()->get() as $service)
                    {{ $service->name}} <br>
                @endforeach
                @else
                  - 
                @endif
                </td>
                <td>
                  @if($user->services())
                @foreach($user->services()->get() as $service)
                    @if( $service->name == 'Premium Access') 
                      Rs. 500 @break
                      @else
                      Rs. 250 @break
                      @endif
                @endforeach
                @else
                  -
                @endif
                </td>
                <td></td>
              </tr>
              @endforeach      
            </tbody>
          </table>
        </div>
        @else
        <div class="card card-body bg-light">
          No Users listed
        </div>
        @endif
        


</div>


@endsection

