
@component('mail::message')
# Hi {{$user['name']}}!, Welcome to Online Library.

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Password : <b>{{$user['password']}}</b>
@endcomponent

Thanks,<br>
Online Library
@endcomponent
