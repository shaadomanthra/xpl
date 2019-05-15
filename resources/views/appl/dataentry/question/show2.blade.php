@extends('layouts.plain')
@section('title', 'Questions | PacketPrep')
@section('content')


      @if($question->question)
         <div class="pt-1 question">{!! $question->question!!}</div>
        @endif

     

 
@endsection