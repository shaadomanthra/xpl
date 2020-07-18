@if(Storage::disk('s3')->exists('articles/'.$exam->slug.'_'.strtolower(str_replace(' ', '', $user->hometown).'.jpg')))
<div class="my-3">
  <picture class="">
    <img 
    src="{{ Storage::disk('s3')->exists('articles/'.$exam->slug.'_'.strtolower(str_replace(' ', '', $user->hometown).'.jpg')) }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
  </picture>
</div>
@elseif(Storage::disk('s3')->exists('articles/'.$exam->slug.'_banner.jpg'))
<div class="my-3">
  <picture class="">
    <img 
    src="{{ Storage::disk('s3')->url('articles/'.$exam->slug.'_banner.jpg') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
  </picture>
</div>
@elseif(Storage::disk('s3')->exists('articles/'.$exam->slug.'_banner.png'))
<div class="my-3">
  <picture class="">
    <img 
    src="{{ Storage::disk('s3')->url('articles/'.$exam->slug.'_banner.png') }} " class="d-print-none w-100" alt="{{  $exam->name }}" >
  </picture>
</div>
@else
@endif