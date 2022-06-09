<div class="bg-light p-3 border rounded">

    <form action="{{ route('assessment.instructions',$exam->slug)}}" method="post" enctype="multipart/form-data">
@if(count($form_fields))
          <div class="mt-3  mb-3 h5 text-primary">Complete the following information</div>
          @foreach($form_fields as $k=>$f)
            @if($f['type']=='input')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <input type="text" class="form-control" name="questions_{{ str_replace(' ','_',$f['name'])}}" required >
            </div>
            @elseif($f['type']=='textarea')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="questions_{{ str_replace(' ','_',$f['name'])}}" rows="{{$f['values']}}" required></textarea>
            </div>
            @elseif($f['type']=='radio')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <select class="form-control" name="questions_{{ str_replace(' ','_',$f['name'])}}"  id="exampleFormControlSelect1">
                @foreach($f['values'] as $v)
                <option value="{{$v}}">{{$v}}</option>
                @endforeach
              </select>
            </div>
            @elseif($f['type']=='file')
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
              <input type="file" class="form-control-file" name="questions_{{ str_replace(' ','_',$f['name'])}}" id="exampleFormControlFile1">
            </div>
            @else
            <div class="js-form-message form-group mb-4">
              <label for="emailAddressExample2" class="input-label">{{$f['name']}}</label>
                @foreach($f['values'] as $m=>$v)
              <div class="form-check">
                <input class="form-check-input" name="questions_{{ str_replace(' ','_',$f['name'])}}[]" type="checkbox" value="{{$v}}" id="defaultCheck{{$m}}">
                <label class="form-check-label" for="defaultCheck{{$m}}">
                  {{$v}}
                </label>
              </div>
              @endforeach
            </div>
            @endif
          @endforeach

          @if($exam->code)
          <div class=" h5 text-primary">Access Code</div>
          <small class="mb-3">This test is private, you have to enter the access code to attempt it.</small>
          <input type="text" class="form-control" name="code" required >
          @endif

           <input type="hidden" name="_token" value="{{ csrf_token() }}">
           <input type="hidden" name="form_fields" value="1">

           <button type="submit" class="btn btn-success mt-3">Attempt Test</button>

      @endif
</form>
</div>