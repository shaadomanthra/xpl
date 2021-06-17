
<ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="chome-tab" data-toggle="tab" href="#cc" role="tab" aria-controls="chome" aria-selected="true">C</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cprofile-tab" data-toggle="tab" href="#ccpp" role="tab" aria-controls="cprofile" aria-selected="false">C++</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="ccontact-tab" data-toggle="tab" href="#ccsharp" role="tab" aria-controls="ccontact" aria-selected="false">C#</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " id="cjava-tab" data-toggle="tab" href="#cjava" role="tab" aria-controls="cjava" aria-selected="false">Java</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cjavascript-tab" data-toggle="tab" href="#cjavascript" role="tab" aria-controls="cjavascript" aria-selected="false">Javascript</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="cpython-tab" data-toggle="tab" href="#cpython" role="tab" aria-controls="cpython" aria-selected="false">Python</a>
                    </li>
                  </ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="cc" role="tabpanel" aria-labelledby="chome-tab">

    <textarea id="code_1" class="form-control code code_1" name="code_c"  rows="5">@if($codes->codefragment_1){{$codes->codefragment_1}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_1" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="1"  data-sno="1"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="clang" data-name="code_1" data-namec="{{\auth::user()->username}}_random_1" data-c="1" data-input="">Submit Code</button>
    <img class="loading loading_1" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
    
    <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_1 ">@if($codes->output_1){{$codes->output_1}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>

    <div class="output_testcase_1">
      <div class="output_testcase_1_t1"></div>
      <div class="output_testcase_1_t2"></div>
      <div class="output_testcase_1_t3"></div>
      <div class="output_testcase_1_t4"></div>
      <div class="output_testcase_1_t5"></div>
    </div>

    <input class="form-control w-50 input_1" type="hidden"  name="1" data-sno="1" value="@if($codes->output_1){{$codes->output_1}}@endif" >
    <input class="form-control w-50 codefragment_1" type="hidden"  name="codefragment_1" data-sno="1" value="@if($codes->codefragment_1){{$codes->codefragment_1}} @endif" >

  </div>
  <div class="tab-pane fade" id="ccpp" role="tabpanel" aria-labelledby="cprofile-tab">

    <textarea id="code_2" class="form-control code code_2" name="dynamic_2"  rows="5">@if($codes->codefragment_2){{$codes->codefragment_2}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_2" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="2"  data-sno="2"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="clang" data-name="code_2" data-namec="{{\auth::user()->username}}_random_2" data-c="0" data-input="">Submit Code</button>
    <img class="loading loading_2" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
      <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_2 ">@if($codes->output_2){{$codes->output_2}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>
    <div class="output_testcase_2">
       <div class="output_testcase_2_t1"></div>
      <div class="output_testcase_2_t2"></div>
      <div class="output_testcase_2_t3"></div>
      <div class="output_testcase_2_t4"></div>
      <div class="output_testcase_2_t5"></div>
    </div>  
     <input class="form-control w-50 input_2" type="hidden"  name="2" data-sno="2" value="@if($codes->output_2){{$codes->output_2}}@endif" >
    <input class="form-control w-50 codefragment_2" type="hidden"  name="codefragment_2" data-sno="2" value="@if($codes->codefragment_2){{$codes->codefragment_2}} @endif" >

  </div>
  <div class="tab-pane fade" id="ccsharp" role="tabpanel" aria-labelledby="ccontact-tab">
    <textarea id="code_3" class="form-control code code_3" name="dynamic_3"  rows="5">@if($codes->codefragment_3){{$codes->codefragment_3}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_3" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="3"  data-sno="3"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="csharp" data-name="code_3" data-namec="{{\auth::user()->username}}_random_3" data-c="0" data-input="">Submit Code</button>
    <img class="loading loading_3" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
      <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_3 ">@if($codes->output_3){{$codes->output_3}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>
    <div class="output_testcase_3">
       <div class="output_testcase_3_t1"></div>
      <div class="output_testcase_3_t2"></div>
      <div class="output_testcase_3_t3"></div>
      <div class="output_testcase_3_t4"></div>
      <div class="output_testcase_3_t5"></div>
    </div>   
     <input class="form-control w-50 input_3" type="hidden"  name="3" data-sno="3" value="@if($codes->output_3){{$codes->output_3}}@endif" >
    <input class="form-control w-50 codefragment_3" type="hidden"  name="codefragment_3" data-sno="3" value="@if($codes->codefragment_3){{$codes->codefragment_3}} @endif" >   
  </div>
  <div class="tab-pane fade" id="cjava" role="tabpanel" aria-labelledby="cjava-tab">
     <textarea id="code_4" class="form-control code code_4" name="dynamic_4"  rows="5">@if($codes->codefragment_4){{$codes->codefragment_4}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_4" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="4"  data-sno="4"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="java" data-name="code_4" data-namec="{{\auth::user()->username}}_random_4" data-c="0" data-input="">Submit Code</button>
    <img class="loading loading_4" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
      <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_4 ">@if($codes->output_4){{$codes->output_4}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>
    <div class="output_testcase_4">
       <div class="output_testcase_4_t1"></div>
      <div class="output_testcase_4_t2"></div>
      <div class="output_testcase_4_t3"></div>
      <div class="output_testcase_4_t4"></div>
      <div class="output_testcase_4_t5"></div>
    </div>      
     <input class="form-control w-50 input_4" type="hidden"  name="4" data-sno="4" value="@if($codes->output_4){{$codes->output_4}}@endif" >
    <input class="form-control w-50 codefragment_4" type="hidden"  name="codefragment_4" data-sno="4" value="@if($codes->codefragment_4){{$codes->codefragment_4}} @endif" > 
  </div>
  <div class="tab-pane fade" id="cjavascript" role="tabpanel" aria-labelledby="cjavascript-tab">
    <textarea id="code_5" class="form-control code code_5" name="dynamic_5"  rows="5">@if($codes->codefragment_5){{$codes->codefragment_5}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_5" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="5"  data-sno="5"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="javascript" data-name="code_5" data-namec="{{\auth::user()->username}}_random_5" data-c="0" data-input="">Submit Code</button>
    <img class="loading loading_5" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
    <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_5 ">@if($codes->output_5){{$codes->output_5}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>
     <div class="output_testcase_5">
       <div class="output_testcase_5_t1"></div>
      <div class="output_testcase_5_t2"></div>
      <div class="output_testcase_5_t3"></div>
      <div class="output_testcase_5_t4"></div>
      <div class="output_testcase_5_t5"></div>
    </div>      
     <input class="form-control w-50 input_5" type="hidden"  name="5" data-sno="5" value="@if($codes->output_5){{$codes->output_5}}@endif" >
    <input class="form-control w-50 codefragment_5" type="hidden"  name="codefragment_5" data-sno="5" value="@if($codes->codefragment_5){{$codes->codefragment_5}} @endif" >
  </div>
  <div class="tab-pane fade" id="cpython" role="tabpanel" aria-labelledby="cpython-tab">
     <textarea id="code_6" class="form-control code code_6" name="dynamic_6"  rows="5">@if($codes->codefragment_6){{$codes->codefragment_6}} @endif </textarea>
    <button type="button" class="btn btn-lg btn-warning btn-sm mt-4 runcode2 runcode_6" data-qslug="{{$question->slug}}" data-test="random" data-testcase="3" data-qno="6"  data-sno="6"  data-url="{{ route('runcode') }}" data-stop="{{ route('stopcode') }}" data-lang="python" data-name="code_6" data-namec="{{\auth::user()->username}}_random_6" data-c="0" data-input="">Submit Code</button>
    <img class="loading loading_6" src="{{asset('img/loading.gif')}}" style="width:80px;padding-left:30px;"/>
    <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Code Output</h5>
        <div class="">
          <pre class="rounded"><code><div class="output_4 ">@if($codes->output_6){{$codes->output_6}}@else-@endif</div></code></pre>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <h5 class="mt-3">Expected Output</h5>
        <div class=""><pre class="rounded"><code><div class=" ">@if(isset($testcases['out_1'])){{$testcases['out_1']}}@else-@endif</div></code></pre>
        </div>
      </div>
    
    </div>
     <div class="output_testcase_6">
       <div class="output_testcase_6_t1"></div>
      <div class="output_testcase_6_t2"></div>
      <div class="output_testcase_6_t3"></div>
      <div class="output_testcase_6_t4"></div>
      <div class="output_testcase_6_t5"></div>
    </div>          
     <input class="form-control w-50 input_6" type="hidden"  name="6" data-sno="6" value="@if($codes->output_6){{$codes->output_6}}@endif" >
    <input class="form-control w-50 codefragment_6" type="hidden"  name="codefragment_6" data-sno="6" value="@if($codes->codefragment_6){{$codes->codefragment_6}} @endif" >
  </div>
</div>



  

