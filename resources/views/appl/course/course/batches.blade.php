@extends('layouts.none')

@section('title', 'Batches')
@section('content')


<div class="p-3">
@if(!request()->get('batches'))
<div class="bg-white ">
  <div class="bg-white border p-3">
    <div class="p-2">
      <h1 class="display-4 mb-3"> <div class="">Enter the Batches </div></h1>
      <form>
        <input type="text" class="form-control w-100 mb-3" name="batches" value="{{ request()->get('batches')}}">
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>    
</div>
@else
<div class="bg-white mb-3">
  <div class="bg-white border p-3">
      <a href="{{ route('course.batches',$course->slug) }}" class="float-right"><button class="btn btn-success">Back</button></a>
    <h1 class="display-4 mb-1"> <div class="">Batch Analysis </div></h1>
    <h4>{{$course->name}}</h4>
     <small class="text-info">{{$d['p_date']->format('d M Y')}} to {{$d['date']->format('d M Y')}}</small>
    <hr>
  
    Best Performer (Weekly Total Ques) - <b>{{$d['btotal_name']}}({{$d['btotal']}}) </b>
     @if (strpos(strtoupper($d['btotal_name']), 'H') !== false)
                  <span class="text-primary">Hyderabad</span>
                @endif

                @if (strpos(strtoupper($d['btotal_name']), 'V') !== false)
                  <span class="text-primary">Vijayawada</span>
                @endif

                @if (strpos(strtoupper($d['btotal_name']), 'Z') !== false)
                  <span class="text-primary">Visakhapatnam</span>
                @endif

                @if (strpos(strtoupper($d['btotal_name']), 'T') !== false)
                  <span class="text-primary">Tirupati</span>
                @endif
    <br>
    Best Performer (Weekly Avg Ques) - <b>{{$d['bavg_name']}}({{$d['bavg']}}) </b>

     @if (strpos(strtoupper($d['bavg_name']), 'H') !== false)
                  <span class="text-primary">Hyderabad</span>
                @endif

                @if (strpos(strtoupper($d['bavg_name']), 'V') !== false)
                  <span class="text-primary">Vijayawada</span>
                @endif

                @if (strpos(strtoupper($d['bavg_name']), 'Z') !== false)
                  <span class="text-primary">Visakhapatnam</span>
                @endif

                @if (strpos(strtoupper($d['bavg_name']), 'T') !== false)
                  <span class="text-primary">Tirupati</span>
                @endif


  
  </div>
</div>
  <div class="row">
  @foreach($data as $bno)
    
        <div class="col-12  mb-3">
            <div class="card w-100">
              <div class="card-header"><h3>{{strtoupper($bno['batch'])}} [{{count($bno['users'])}}]</h3>
                @if (strpos(strtoupper($bno['batch']), 'H') !== false)
                  <span class="text-primary">Hyderabad</span>
                @endif

                @if (strpos(strtoupper($bno['batch']), 'V') !== false)
                  <span class="text-primary">Vijayawada</span>
                @endif

                @if (strpos(strtoupper($bno['batch']), 'Z') !== false)
                  <span class="text-primary">Visakhapatnam</span>
                @endif

                @if (strpos(strtoupper($bno['batch']), 'T') !== false)
                  <span class="text-primary">Tirupati</span>
                @endif
              </div>
              <div class="card-body">
                <b>
                <div class="row">
                
                    <div class="col-4">
                      Name
                    </div>
                    <div class="col-2">
                      Details
                    </div>
                    <div class="col-2">
                      Ques Solved
                    </div>
                    <div class="col-2">
                      Tests Attempted
                    </div>
                     <div class="col-2">
                      Avg CGPA
                    </div>
                </div>
              </b>
                @if(isset($bno['practice_set']))
                @foreach($bno['practice_set'] as $a=>$b)
                <div class="row">
                    <div class=""> <span class="float-right"></span></div>
                    <div class="col-4">
                      <a href="{{ route('profile','@'.$bno['users'][$a]->username) }}" class="">{{$bno['users'][$a]->name}}</a>
                    </div>
                    <div class="col-2">
                      @if($bno['users'][$a]->branch_id){{$branches[$bno['users'][$a]->branch_id]->name }} | @endif
                       {{$bno['users'][$a]->year_of_passing}}<br>
                       [10th - {{$bno['users'][$a]->tenth}}%, 12th - {{$bno['users'][$a]->twelveth}}%, Btech - {{$bno['users'][$a]->bachelors}}%]
                    </div>
                    <div class="col-2">
                      {{$b}} / {{$course->ques_count}}
                      <div class="progress" style="height:8px">
                        <div class="progress-bar" role="progressbar" style="width: {{round($b/$course->ques_count*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                    <div class="col-2">
                      @if(isset($bno['tests_overall'][$a]))
                        {{count($bno['tests_overall'][$a])}}
                        <div class="progress" style="height:8px">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{round( count($bno['tests_overall'][$a])/count($course->exams)*100,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      @else
                      0 / {{count($course->exams)}}
                      @endif 

                    </div>
                    <div class="col-2">
                      @if(isset($bno['tests_overall'][$a]))
                        {{round($bno['tests_overall'][$a]->avg('score')*10/$bno['tests_overall'][$a]->avg('max'),2)}} / 10
                        <div class="progress" style="height:8px">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{round($bno['tests_overall'][$a]->avg('score')*10/$bno['tests_overall'][$a]->avg('max')*10,2)}}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      @else
                      0 / 10
                      @endif 
                    </div>
                </div>
                @endforeach
                @endif
                    
                
               
              </div>
              <div class="card-footer">
                 Student Count: {{count($bno['users'])}}<br>
           Total Solved Questions : {{($bno['pavg']*count($bno['users']))}}<br>
        
        Total Avg Practice Ques : <b>{{round($bno['pavg'],2)}}</b><br>
        <span class="text-info">Last 7 days Solved Questions : <b>{{($bno['wpavg']*count($bno['users']))}}</b></span><br>
        <span class="text-info">Last 7 days Avg Practice Ques : <b>{{round($bno['wpavg'],2)}}</b></span><br>
              </div>
            </div>
        </div>
    
  @endforeach
  </div>
  
@endif
</div>
@endsection           