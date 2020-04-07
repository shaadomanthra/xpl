
@component('mail::message')
# Hi {{$user['name']}}!,

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Password : <b>{{$user['password']}}</b><br>
Url : <a href="https://xplore.co.in/login">xplore.co.in/login</a>
@endcomponent

Thanks,<br>
Xplore
@endcomponent
