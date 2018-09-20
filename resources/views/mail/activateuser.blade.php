
@component('mail::message')
# Hi {{$user['name']}}!, Welcome to Online Library.

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Password : <b>{{$user['password']}}</b><br>
Url : <a href="https://{{ $user['client_slug'] }}.onlinelibrary.co">{{ $user['client_slug'] }}.onlinelibrary.co</a>
@endcomponent

Thanks,<br>
Online Library
@endcomponent
