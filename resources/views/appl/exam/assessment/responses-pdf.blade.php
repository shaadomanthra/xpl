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
          <div class=' ' style=" padding-bottom: 30px; ">
          <p class="heading_two mb-1 f30" ><h4> {{$student->name}}</h4>

          </p>
          @if($student->roll_number)<span class="badge badge-warning ">Roll Number : {{$student->roll_number}}</span> <br>@endif
          @if($student->email)<span class="badge badge-info ">Email : {{$student->email}}</span> <br>@endif
          @if($student->phone)<span class="badge badge-info ">Phone : {{$student->phone}}</span> <br>@endif
          @if($student->roll_number)<span class="badge badge-warning ">Roll Number : {{$student->roll_number}}</span> <br>@endif
          @if($student->branch_id)<span class="badge badge-danger ">Branch : {{$student->branch->name}}</span><br>@endif
      @if($student->college_id)<span class="badge badge-success">College : {{$student->college->name}}</span><br>@endif
      <p class="pt-3">Exam : <span class="text-primary">{{ ucfirst($exam->name) }}</span></p>
      <p class="pt-3"><b>Score : @if(!$test_overall->status)
      <span class="">{{ $test_overall->score }} </span>
      @else
      <span class="badge badge-primary under_review_main" >Under Review</span>
      @endif</b></p>
        </div>
           <div class="">
           @foreach($tests as $k=>$t)
          
            <div class="mb-3" style="padding:20px; margin:5px;background: #f8f8f8;border:1px solid silver;">
               @if($t->question->type=='code')
                <pre class="mb-3" style="">
                      <code style="overflow-wrap: break-word;word-wrap: break-word">
                        {!! htmlentities($t->code) !!}
                      </code>
                    </pre>

                @endif
            </div>


@endforeach
</div>
        </main>
    </body>
</html>
