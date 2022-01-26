@if($codes)
@if($question->b)
<style>
  .nocopy{
    -moz-user-select: none;  
-webkit-user-select: none;  
-ms-user-select: none;  
-o-user-select: none;  
user-select: none;
  }
  </style>
<div class="border p-3 mb-3 mb-md-0" style="background: #d5d5d5;">
        <div class="">
          <h3 class="mb-3">Code Solution</h3>
           

          <div class="nocopy">
           <pre class="p-3"><code class="text-light ">{!! htmlentities($codes['codefragment']) !!}</code></pre>
         </div>
        



</div>
</div>
@else
@endif
@else


@endif

@if(isset($codes['output']))
<div class="card mt-2"><div class="card-header">Expected Output</div><div class="card-body">{!! htmlentities($codes['output']) !!}</div></div>
@endif
