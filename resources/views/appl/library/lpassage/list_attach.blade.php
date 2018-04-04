 
 @if(count($lpassages)!=0)
 <div class="table-responsive">
  <table class="table table-bordered mb-0">
    <thead>
      <tr>
        <th scope="col">Passage </th>
        <th scope="col">Connect</th>
      </tr>
    </thead>
    <tbody>
      @foreach($lpassages as $key=>$lpassage)  
      <tr>
        <td>
          <a href=" {{ route('lpassage.show',[$repo->slug,$lpassage->id]) }} ">
            {{ $lpassage->name }}
          </a>
          <div class="passage_{{$lpassage->id}}">
            {!! str_limit(strip_tags($lpassage->passage),200) !!}
          </div>
        </td>
        <td><button type="button" class="btn btn-primary btn-attach" data-id="{{$lpassage->id}}">Attach</button></td>
      </tr>
      @endforeach      
    </tbody>
  </table>
</div>
@else
<div class="card card-body bg-light">
  No Passages Listed !
</div>
@endif

