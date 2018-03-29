 
 @if(count($passages)!=0)
 <div class="table-responsive">
  <table class="table table-bordered mb-0">
    <thead>
      <tr>
        <th scope="col">Passage </th>
        <th scope="col">Connect</th>
      </tr>
    </thead>
    <tbody>
      @foreach($passages as $key=>$passage)  
      <tr>
        <td>
          <a href=" {{ route('passage.show',[$project->slug,$passage->id]) }} ">
            {{ $passage->name }}
          </a>
          <div class="passage_{{$passage->id}}">
            {!! str_limit(strip_tags($passage->passage),200) !!}
          </div>
        </td>
        <td><button type="button" class="btn btn-primary btn-attach" data-id="{{$passage->id}}">Attach</button></td>
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

