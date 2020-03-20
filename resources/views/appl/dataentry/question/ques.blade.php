<div class="bg-light p-3 border">
<div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Question </a>
  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Version 2</a>
  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Version 3</a>
  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Version 4</a>
</div>
<div class="tab-content" id="v-pills-tabContent">
  <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
  	<div class="form-group mt-3">
        <label for="formGroupExampleInput2">Question - Default</label>
         <textarea class="form-control summernote" name="question"  rows="5">
            @if($stub=='Create')
            {{ (old('question')) ? old('question') : '' }}
            @else
            {{ $question->question }}
            @endif
        </textarea>
      </div>
  </div>
  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
  	<div class="form-group mt-3">
        <label for="formGroupExampleInput2">Question - Version 2</label>
         <textarea class="form-control summernote" name="question_b"  rows="3">
            @if($stub=='Create')
            {{ (old('question_b')) ? old('question_b') : '' }}
            @else
            {{ $question->question_b }}
            @endif
        </textarea>
      </div>
  </div>
  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
  	 <div class="form-group mt-3">
        <label for="formGroupExampleInput2">Question - Version 3</label>
         <textarea class="form-control summernote" name="question_c"  rows="3">
            @if($stub=='Create')
            {{ (old('question_c')) ? old('question_c') : '' }}
            @else
            {{ $question->question_c }}
            @endif
        </textarea>
      </div>
  </div>
  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
  	<div class="form-group mt-3">
        <label for="formGroupExampleInput2">Question - Version 4</label>
         <textarea class="form-control summernote" name="question_d"  rows="3">
            @if($stub=='Create')
            {{ (old('question_d')) ? old('question_d') : '' }}
            @else
            {{ $question->question_d }}
            @endif
        </textarea>
      </div>
  </div>
</div>
</div>