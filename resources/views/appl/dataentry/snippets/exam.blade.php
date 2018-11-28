<div class="form-group mt-3">
  
  @if(count($exams)!=0)
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead>
        <tr>
          <th scope="col">Exams </th>
          <th scope="col">Sections</th>
        </tr>
      </thead>
      <tbody>
        @foreach($exams as $exam)  
        <tr>
          <td>
            {{ $exam->name }}
          </td>
          <td>
            @foreach($exam->sections as $a => $section)
            @if($a==0)
            <input  type="checkbox" name="sections[]" value="{{$section->id}}" 
              @if($stub=='Create')
                @if(old('section'))
                  @if(in_array($section->id,old('section')))
                  checked
                  @endif
                @endif
              @else
                @if($question->sections)
                  @if(in_array($section->id,$question->sections->pluck('id')->toArray()))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{ $section->name}}
            @else
            {{','}}
            <input  type="checkbox" name="sections[]" value="{{$section->id}}"
              @if($stub=='Create')
                @if(old('section'))
                  @if(in_array($section->id,old('section')))
                  checked
                  @endif
                @endif
              @else
                @if($question->sections)
                  @if(in_array($section->id,$question->sections->pluck('id')->toArray()))
                  checked
                  @endif
                @endif
              @endif
            > 
            {{$section->name }}
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
    No Exams listed
  </div>
  @endif
</div>