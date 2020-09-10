
        

         
      @if(count($report)!=0)
        <div class="row mb-4">
              @foreach($report as $key=>$r)  
              @if(Storage::disk('s3')->exists('webcam/'.$r->user->username.'_'.$exam->id.'_1.jpg'))
                    @for($i=1;$i<2;$i++)
                      @if(Storage::disk('s3')->exists('webcam/'.$r->user->username.'_'.$exam->id.'_'.$i.'.jpg'))
                      <div class='col-6 col-md-2'>
                        <img src="{{ Storage::disk('s3')->url('webcam/'.$r->user->username.'_'.$exam->id.'_'.$i.'.jpg') }}" class="mb-2 u_{{$key}}" data-name="{{$r->user->username.'_'.$exam->id}}" data-number="1" style="height:100px" />
                        u_{{$key}}
                      </div>
                      @endif
                    @endfor
              @endif
              @endforeach
           </div>   
       
        
        @else
        <div class="card card-body bg-light">
          No Reports listed
        </div>
        @endif  
      </div>
