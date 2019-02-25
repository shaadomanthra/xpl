@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>
    <li class="breadcrumb-item "><a href="{{ route('recruit')}}">Recruit</a></li>
    <li class="breadcrumb-item "><a href="{{ route('form.index')}}">Forms</a></li>
    <li class="breadcrumb-item active" aria-current="page">
      {{ $form->id }}
    </li>
  </ol>
</nav>

  @include('flash::message')

  <div class="row ">

    <div class="col-md-12">
      <div class="card  ">
        <div class="card-body ">
          
          <nav class="navbar navbar-light bg-light justify-content-between border mb-3 p-3">
          <a class="navbar-brand"><i class="fa fa-user"></i> Applicant ID: {{ $form->id }}
            </a>
        </nav>

        <div class="table-responsive ">
          <table class="table table-bordered mb-3">
            <thead>
            </thead>
            <tbody>
              <tr>
                <td>Name</td>
                <td> <a href="{{ route('admin.user.view',$form->username) }}">{{ $form->name }}</a></td>
              </tr> 
              <tr>
                <td>Email </td>
                <td> {{ $form->email }}</td>
              </tr>

               <tr>
                <td>College </td>
                <td> {{ ($form->college) ? ($form->college) : '-' }}</td>
              </tr>

               <tr>
                <td>Branch </td>
                <td> {{ ($form->branch) ? ($form->branch) : '-' }}</td>
              </tr>
              <tr>
                <td>Phone</td>
                <td>{{ $form->phone }}</td>
              </tr>  
              <tr>
                <td>Date of Birth</td>
                <td>{{ \carbon\carbon::parse($form->dob)->format('M d Y') }}</td>
              </tr> 
              <tr>
                <td>Age</td>
                <td>{{ \carbon\carbon::parse($form->dob)->age }} years</td>
              </tr> 
              <tr>
                <td>Address</td>
                <td>{!! $form->address !!}</td>
              </tr> 
              <tr>
                <td>Education</td>
                <td>{!! $form->education !!}</td>
              </tr> 
              <tr>
                <td>Experience</td>
                <td>{!! $form->experience !!}</td>
              </tr> 
              <tr>
                <td>Status</td>
                <td>
                  @if($form->status==0) 
                  <span class="badge badge-secondary">Open</span>
                  @elseif($form->status==1)
                  <span class="badge badge-success">Accepted</span>
                  @else
                  <span class="badge badge-danger">Rejected</span>
                  @endif
                </td>
              </tr> 
              <tr>
                <td>Reason</td>
                <td>{!! $form->reason !!}</td>
              </tr> 
            </tbody>
          </table>
        </div>

       
        
        @can('update',$form)
           <span class="btn-group mt-4" role="group" aria-label="Basic example">
              <a href="{{ route('form.edit',$form->id) }}" class="btn btn-outline-primary" data-tooltip="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
              
              <a href="#" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i></a>
            </span>
        @endcan
        </div>
      </div>


    </div>


  </div> 


  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 ><span class="badge badge-danger">Serious Warning !</span></h3>
        This following action will delete the node and this is permanent action and this cannot be reversed.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        <form method="post" action="{{route('form.destroy',['job_id'=>$form->id])}}">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<button type="submit" class="btn btn-danger">Delete Permanently</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection