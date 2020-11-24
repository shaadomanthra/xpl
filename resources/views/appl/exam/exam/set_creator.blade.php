@extends('layouts.nowrap-white')
@section('title', 'Set Creator - '.$exam->name)
@section('content')

@include('appl.exam.exam.xp_css')

<div class="dblue" >
  <div class="container">

    <nav class="mb-0">
          <ol class="breadcrumb  p-0 pt-3 " style="background: transparent;" >
            <li class="breadcrumb-item"><a href="{{ url('/home')}}">Home</a></li>

            <li class="breadcrumb-item"><a href="{{ route('exam.show',$exam->slug) }}">{{$exam->name}}</a></li>
            <li class="breadcrumb-item">Set Creator </li>
          </ol>
        </nav>
    <div class="row">
      <div class="col-12 col-md-8">

        <div class=' pb-1'>
          <p class="heading_two mb-2 f30" ><i class="fa fa-bars "></i> Set Creator
          </p>
        </div>
      </div>

    </div>
  </div>
</div>
<div class='p-1  ddblue' ></div>


@include('flash::message')

<div class="container">
  <div  class="  mb-4 mt-4">
    @if(($data['level'] != 0 || $data['no_topic'] != 0) && !request()->get('admin'))
     <div class="alert alert-important alert-warning">
       <h3><span class="badge badge-warning">Important !</span></h3>
       <div>To create question paper set, it is mandatory to assign topic & level for every question. </div>
       <hr>
       <p><b>Questions Count:</b> {{$data['qcount']}} &nbsp; &nbsp; &nbsp; <b>No Topics Count:</b> {{$data['no_topic']}} &nbsp; &nbsp; &nbsp; <b>No Level Count:</b> {{$data['level']}} </p>
     </div>
    @else

    <div class="alert alert-important alert-warning">
       <h3><span class="badge badge-warning">Instructions</span></h3>
       <div class="mb-4">You can insert the algorithm in json format as below. The algorithm code is optional, if the feild is empty then all questions are pickedup. On clicking the save button, 10 question paper sets are created with random selection. </div>
       <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
              <div class="p-3"><h4>Example 1</h4> In the below example code, the questions are tagged under level1,level2 and level3 and topic names are given as unit-5 and unit-6. This algorithm will pickup 6 questions from level1, 5 questions from level2 and 4 questions from level3.</div>
                <pre><code class="text-light">{
    "level1": {
        "unit-5": "3",
        "unit-6": "3"
    },
    "level2": {
        "unit-5": "2",
        "unit-6": "3"
    },
    "level3": {
        "unit-5": "2",
        "unit-6": "2"
    }
}</code></pre> 
            </div>
        </div>
        <div class="col-12 col-md-6">
           <div class="card">
              <div class="p-3"><h4>Example 2</h4> In the below example code, the questions are tagged under level1,level2 and level3 and topic names are given as chapter-1 and chapter-2. This algorithm will pickup 15 questions and total score is the aggregate of top 5 marks awarded.</div>
                <pre><code class="text-light">{
    "level1": {
        "chapter-1": "2",
        "chapter-2": "2"
    },
    "level2": {
        "chapter-1": "3",
        "chapter-2": "2"
    },
    "level3": {
        "chapter-1": "4",
        "chapter-2": "2"
    },
    "score_best":"5"
}</code></pre> 
            </div>
        </div>
       </div>
       <p></p>
       <p> Validate the json code at <a href="https://jsonformatter.curiousconcept.com/">https://jsonformatter.curiousconcept.com/ </a></p>
     </div>

    

    <form method="post" action="{{route('test.sets',$exam->slug)}}" enctype="multipart/form-data">
    <table class="table table-bordered">
      <thead class="bg-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Sections</th>
          <th scope="col">Paper Structure</th>
        </tr>
      </thead>
      <tbody>
        @foreach($exam->sections as $m=>$sec)

        <tr>
          <th scope="row">{{$m+1}}</th>
          <td>{{$sec->name}} [{{$sec->id}}]</td>
          <td>

            
             <label for="formGroupExampleInput ">Algorithm</label><textarea class="form-control summernote" name="{{$sec->id}}"  rows="5">@if($sec->instructions) {{json_encode(json_decode($sec->instructions), JSON_PRETTY_PRINT)}} @endif</textarea>
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
     <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="btn btn-success" type="submit">Save</button>
    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-tooltip="tooltip" data-placement="top" title="Delete" ><i class="fa fa-trash"></i> Delete</a>
    </form>


    @endif

    @if(count($paper_sets))
    <div class="bg-light p-3 border my-3 rounded">
      <h4>Question Paper Sets </h4>
      @foreach($paper_sets as $i=>$set)
       <a href="{{ route('test.questionlist',$exam->slug)}}?set={{$i}}" class="btn btn-outline-primary">
  Set {{$i}} <span class="badge badge-primary">{{$paper_count[$i]}}Q</span>
</a>
      @endforeach
       

    </div>
    @else
    <div class="bg-light p-3 border my-3">
        No question paper sets created.
    </div>

    @endif


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
        Kindly note that, deleting question paper set can tamper the scores of the students who have attemped the test. 
        <hr>
        Delete the sets only if no student has attempted the test.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
        
          <a href="{{route('test.sets',$exam->slug)}}?delete=1" class="btn btn-danger">I confirm, Delete Permanently</a>
       
      </div>
    </div>
  </div>
</div>



@endsection
