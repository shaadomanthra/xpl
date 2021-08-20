
@component('mail::message')
# Hi {{$user['name']}}!,

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Password : <b>{{$user['password']}}</b><br>
Url : <a href="https://{{ $_SERVER['HTTP_HOST'] }}/login">{{ $_SERVER['HTTP_HOST'] }}/login</a>
@endcomponent

Thanks,<br>
{{ env('APP_NAME') }}
@endcomponent
