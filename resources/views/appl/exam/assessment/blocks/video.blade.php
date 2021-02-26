<div id="container">

    
    <div class='alert alert-warning alert-important'>The recording automatically starts after 5 secs and ends upon completion of timer or manual submission of test.</div>

    <video id="gum_{{$question->id}}" playsinline autoplay muted style="width:200px;height:200px; border-radius:8px;"></video>
    <video id="recorded" playsinline loop></video>
    <div class="recording text-danger " style="display: none"><span class="blink"><i class="fa fa-circle"></i></span> Recording</div>

    <div>
        <button id="start" type="button" class='d-none'>Start camera</button>
        <button id="record" type="button" class="btn btn-outline-danger d-none" disabled>Start Recording</button>
        <button id="play"  type="button" class='d-none' disabled>Play</button>
        <button id="download" type="button" class='d-none' disabled>Download</button>
    </div>


</div>