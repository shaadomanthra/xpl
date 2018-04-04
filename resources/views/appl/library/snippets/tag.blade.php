<div class="form-group mt-3">
  
  @if(count($tags)!=0)
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead>
        <tr>
          <th scope="col">Tag </th>
          <th scope="col">Values</th>
        </tr>
      </thead>
      <tbody>
        @foreach($tags as $key=>$coll)  
        <tr>
          <td>
            {{ $key }}
          </td>
          <td>
            @foreach($coll as $a=>$tag)
            @if($a==0)
            <input  type="checkbox" name="tag[]" value="{{$tag->id}}" 
              @if($stub=='Create')
                @if(old('tag'))
                  @if(in_array($tag->id,old('tag')))
                  checked
                  @endif
                @endif
              @else
                @if($question->tags)
                  @if(in_array($tag->id,$question->tags))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{ $tag->value}}
            @else
            {{','}}
            <input  type="checkbox" name="tag[]" value="{{$tag->id}}"
              @if($stub=='Create')
                @if(old('tag'))
                  @if(in_array($tag->id,old('tag')))
                  checked
                  @endif
                @endif
              @else
                @if($question->tags)
                  @if(in_array($tag->id,$question->tags))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$tag->value }}
            @endif
            @endforeach
          </td>
        </tr>
        @endforeach  
      </tbody>
    </table>
  </div>
  @else
  <div class="card card-body bg-light">
    No Tags listed
  </div>
  @endif
</div>