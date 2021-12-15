<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 1cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 1cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                background-color: #f8f8f8;
                color: white;
                line-height: 1cm;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/
                
                color: #1f70ab;
                text-align: center;
                line-height: 1.5cm;
            }

            hr{ 
              height: 1px;
              color: red;
              background-color: #eee;
              border: none;
            }

            .question{
                color: #1f70ab;
            }
            .answer{
                color: #16a085;
            }
            i{
                color: #48dbfb;
            }

            body { background: #fff; color: #444; margin:0px;
    font: 14px/21px;font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;}

/* Typography */
  p { margin: 0 0 20px 0; }
  strong { font-weight: bold; color: #333; }
  small { font-size: 80%; color:#B8B8B8 ; }
  hr { border: solid #ddd; border-width: 1px 0 0; clear: both; margin: 10px 0 10px; height: 0; }

  h1{ font-size:35px; line-height: 40px; }
  h2{ font-size:30px; line-height: 35px; }
  h3{ font-size:25px; line-height: 30px; }
  h4{ font-size:20px; line-height: 23px; }
  h5{ font-size:16px; line-height: 18px; }
  h6{ font-size:14px; line-height: 16px; }

/* Links */
  a, a:visited { color: #333; text-decoration: none; outline: 0; }
  a:hover, a:focus { color: #000; }
  p a, p a:visited { line-height: inherit; }

/* Table */
  .table{ padding: 5px 0px; width:100%; border-collapse: collapse; text-align: left; border: 1px solid #D2D7D3;margin-bottom: 15px;}
  .table th{ font-size: 14px;font-weight: normal;
        color: #22313F; padding: 10px 8px; border-bottom: 1px solid #D2D7D3;background: #f8f8f8;text-align: left;}
  .table td{ color: #22313F;padding: 9px 8px 0px 8px; border-bottom: 1px solid #D2D7D3;}
  .table tbody tr:hover td{ color:#6C7A89;}
  .table td p,.table th p{margin-bottom: 0px;padding-bottom: 0px;}
/* Elements */
  .well{ background: #F8f8f8; margin-bottom:20px;padding: 10px; border-radius: 10px; border-bottom: 5px solid #EEEEEE;border-right:2px solid #EEEEEE;}  
  .box{ border:2px solid #EEEEEE; border-radius: 5px; padding: 10px;}

/* input */
  fieldset{ border: 2px solid #EEEEEE;padding: 20px; }
  input[type="text"], 
  input[type="password"],
  textarea,
  select{
    font-size:100%;border:0; padding:8px; font-size:1em; color:#34495e; border:solid 1px #ccc; margin:5px 0 5px; 
    -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
  -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;}
  textarea{ font-size: 1.4em;}


/* button */
  .btn{
      padding: 8px 15px;color: #FFF;background: #3498db;  
      -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;
      cursor: pointer;border: solid 0px transparent; }
  .btn:hover { opacity:0.9;}


/* Container */
  .bcontainer{
    max-width:1000px;
    margin:0px auto;
    padding:30px;
  }

/*grid */

  .brow { margin:0px auto; word-wrap: break-word;clear: both; }
  .bcol-5{ width:5%; }
  .bcol-10{ width:10%; }
  .bcol-15{ width:15%; }
  .bcol-20{ width:20%; }
  .bcol-25{ width:25%; }
  .bcol-30{ width:30%; }
  .bcol-33{ width:33.3%; }
  .bcol-40{ width:40%; }
  .bcol-50{ width:50%; }
  .bcol-60{ width:60%; }
  .bcol-66{ width:66.7%; }
  .bcol-70{ width:70%; }
  .bcol-75{ width:75%; }
  .bcol-80{ width:80%; }
  .bcol-85{ width:85%; }
  .bcol-90{ width:90%; }
  .bcol-95{ width:94.5%; }
  .bcol-100{ width:99.5%; }
  .w-100{width: 70%;padding-top: 20px;}

  .brow:after {content: "";display: table;clear: both;margin-bottom: 5px;}
  /*[class*='bcol-'] { float: left; }  */
  .text-success{ color:green; background: #eee;padding:3px 5px; border-radius: 4px; } 
  .text-danger{color:red;  background: yellow;padding:3px 5px; border-radius: 4px;}
  .font-weight-bold{font-weight: bold}
  .clear{clear: both}
 .mb-3{padding:5px;margin-bottom:5px;}
        </style>
    </head>
    <body>

      
        <!-- Define header and footer blocks before your content -->
        <!-- Wrap the content of your PDF inside a main tag -->
        <main class="bcontainer">

            
          <div id="pdf" style="padding:20px ;">
            <img src="https://xp.test/img/xplore.png" style="width:100px;border-radius: 10px;margin-bottom: 25px;"/>
          <div class=' ' style=" padding-bottom: 30px;  ">
          <p class="heading_two mb-1 f30 "  ><h4> {{ ucfirst($exam->name) }} - Report</h4>

          </p>

          @if(isset($images['webcam']))
            <img src="{{ $images['webcam'][1]}}" style="float: right;width:150px;border-radius: 10px;margin-top: 15px;"/>
          @endif
          <h4 style="color:#c44569;margin-bottom: 3px"> {{ ucfirst($student->name) }}</h4>
            @if($student->college_id)@if(isset($student->college->name))<span class="badge badge-info"><b>College :</b> {{$student->college->name}}</span><br>@endif @endif
           @if($student->branch_id)@if(isset($student->branch->name))<span class="badge badge-danger "><b>Branch : </b>{{$student->branch->name}}</span><br>@endif @endif

          @if($student->roll_number)<span class="badge badge-warning "><b>Roll Number :</b> {{$student->roll_number}}</span> <br>@endif
            <span><b>Year of passing :</b> <span class="text-primary">{{ $student->year_of_passing }}</span><br>
     
             @if($student->current_city)<span class="badge badge-warning "><b>Currenty City:</b> {{$student->current_city}}</span> <br>@endif
               @if($student->hometown)<span class="badge badge-warning "><b>Hometown :</b> {{$student->hometown}}</span> <br>@endif

        <br><br><br>

      
        <div class="brow">
          <div class="bcol-25" style="width:30%;float: left;">
            <div style="background: #b8e994;border-radius:5px;padding:15px;margin-right:20px;">
              <div>Score</div>
              @if(!$test_overall->status)
              <h1>{{$test_overall->score}}</h1>
              <div>out of {{$test_overall->max}}</div>
                @else
      <span class="badge badge-primary under_review_main" >Under Review</span>
      @endif
            </div>
          </div>
          <div class="bcol-25" style="width:30%;float: left;">
            <div style="background: #82ccdd;border-radius:5px;padding:15px;margin-right:20px;">
              <div>Percentage</div>
              <h1>{{ round($test_overall->score/$test_overall->max*100,1) }}%</h1>
              <div>out of 100</div>
            </div>
          </div>
          <div class="bcol-25" style="width:30%;float: left;">
            <div style="background: #f8c291;border-radius:5px;padding:15px;margin-right:20px;">
              <div>Rank</div>
              @if(isset($rank['rank']))
              <h1>{{$rank['rank']}}</h1>
              <div>out of {{$rank['participants']}}</div>
              @endif
            </div>
          </div>
         
        </div>
        </div>
        <br><br><br><br><br><br><br><Br><br><br><br><Br>
        <table class="table ">
          <tr><th>Board</th><th>Percentage/CGPA</th></tr>
          <tr>
            <td>Class 10</td>
            <td>{{$student->tenth}}</td>
          </tr>
          <tr>
            <td>Class 12</td>
            <td>{{$student->twelveth}}</td>
          </tr>
          <tr>
            <td>Graduation</td>
            <td>{{$student->bachelors}}</td>
          </tr>
          <tr>
            <td>Masters</td>
            <td>{{$student->masters}}</td>
          </tr>
        </table>
        <br><br><br><br><br><br><br>
           <div class="">
            <h3> Responses</h3>
           @foreach($tests as $k=>$t)
          
           <table class="table ">
              <tbody>
                <tr>
                  <th scope="row" width="10%">{{($k+1)}}</th>
                  <th>{!! $t->question->question !!}</th>
                </tr>
                @if($t->question->type!='code')
                @if($t->question->option_a)
                <tr>
                  <td scope="row" class=""><span class=" @if($t->answer=='A') text-success font-weight-bold @endif">(A) </span></td>
                  <td>{!! $t->question->option_a!!}</td>
                </tr>
                @endif

                @if($t->question->option_b)
                <tr>
                   <td scope="row" class=""><span class=" @if($t->answer=='B') text-success font-weight-bold @endif">(B) </span></td>
                  <td>{!! $t->question->option_b!!}</td>
                </tr>
                @endif

                @if($t->question->option_c)
                <tr>
                   <td scope="row" class=""><span class=" @if($t->answer=='C') text-success font-weight-bold @endif">(C) </span></td>
                  <td>{!! $t->question->option_c!!}</td>
                </tr>
                @endif

                @if($t->question->option_d)
                <tr>
                  <td scope="row" class=""><span class=" @if($t->answer=='D') text-success font-weight-bold @endif">(D) </span></td>
                  <td>{!! $t->question->option_d!!}</td>
                </tr>
                @endif

                @if($t->question->option_e)
                <tr>
                   <td scope="row" class=""><span class=" @if($t->answer=='E') text-success font-weight-bold @endif">(E) </span></td>
                  <td>{!! $t->question->option_e!!}</td>
                </tr>
                @endif
                @endif

                @if($t->question->type=='code')
                <tr>
                  <td scope="row" class="">User Code</td>
                  <td><pre class="mb-3" style=""><code style="overflow-wrap: break-word;word-wrap: break-word">{!! htmlentities($t->code) !!}
                      </code>
                    </pre>
                  </td>
                </tr>
                

                @endif

                
                <tr>
                  <td scope="row" class="">User<br><small> Response</small></td>
                  <td>
                     @if(trim(strip_tags($t->response)))
                      {!! nl2br($t->response) !!} 
                      @else
                        @if($t->question->type=='urq')
                             @if(isset($questions[$t->question_id]->images))
                                @if(count($questions[$t->question_id]->images))
                                @foreach(array_reverse($questions[$t->question_id]->images) as $k=>$url)
                                  <br><br>
                                   <img src="{{$url }}"  class="w-100"/>
                                
                                @endforeach
                                @endif
                              @endif

                        @else
                          -
                        @endif
                      
                      @endif

                      @if($t->accuracy)
                      @if($t->question->type=='mcq' || $t->question->type=='maq' || $t->question->type=='fillup')

                        @if($t->mark==0)
                        <sapn class="fa fa-times-circle text-danger"> incorrect </span>
                        @else
                        <span class="fa fa-check-circle text-success"> correct</span>
                        @endif
                      @else
                      <i class="fa fa-check-circle text-success"></i>
                      @endif
                    @else

                      @if($t->question->type=='mcq' || $t->question->type=='maq' || $t->question->type=='fillup')
                      <i class="fa fa-times-circle text-danger">incorrect</i>
                      @else
                        @if($t->mark==0 && $t->question->type!='urq' && $t->question->type!='sq')
                        <i class="fa fa-times-circle text-danger"> correct</i>
                        @endif
                      @endif
                    @endif
                  </td>
                </tr>
                 <tr>
                  <td scope="row" class="">Marks<br><small>Awarded</small></td>
                  <td>
                    {{$t->mark}}
                  </td>
                </tr>
                
                
              </tbody>
            </table>

            @endforeach

          @if(isset($images['webcam']))
            <br><br>
            <h3>Images</h3>
            <br><br>

              @foreach($images['webcam'] as $j=>$l)
              <img src="{{ $l}}" style="margin-top: 5px"/>
              @endforeach
              <br>
              <a href="{{ route('test.snaps',$exam->slug)}}?type=snaps&username={{$student->username}}">>view all images</a>
            <br><br>
            @endif
            <h3>Log</h3>
            <br><br>
            <div style="">
        @if(isset($content['os_details']))
        <div>OS details: <b><span class="log_os text-muted">{{$content['os_details']}}</span></b></div>
         
        <div>Browser details: <b><span class="log_browser text-muted">{{$content['browser_details']}}</span></b></div>

        <div>IP Address: <b><span class="log_ip text-muted">{{$content['ip_details']}}</span></b></div>

        <div>Window Swaps: <b><span class="log_swaps text-danger">{{$content['window_change']}}</span></b></div>
        <div>Date: <b><span class="log_swaps text-primary">{{date("jS F, Y", $content['last_updated'])}}</span></b></div>
           @endif
        <hr>
        
         @if(isset($content['activity']))
         @foreach($content['activity'] as $a => $b)
         <div class="row">
            <div class="col-3">{{date(' h:i:s ', $a)}} -  {{$b}}</div>
            
          </div> 
          @endforeach
          @endif
          
          </div>
  
</div>



</div>
        </main>
    </body>
</html>
