
@component('mail::message')
# Hi {{$user['name']}}!, 

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Url : <a href="{{$_SERVER['HTTP_HOST']}}">{{$_SERVER['HTTP_HOST']}}</a>
@endcomponent

Thanks,<br>
Web Admin
@endcomponent
