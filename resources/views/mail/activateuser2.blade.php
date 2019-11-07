
@component('mail::message')
# Hi {{$user['name']}}!, Welcome to Xplore.

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Url : <a href="https://xplore.co.in">xplore.co.in/login</a>
@endcomponent

Thanks,<br>
Xplore
@endcomponent
