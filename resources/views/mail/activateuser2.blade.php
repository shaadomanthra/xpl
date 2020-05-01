
@component('mail::message')
# Hi {{$user['name']}}!, 

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Activation Link : <a href="{{ route('activateuser',$user->activation_token)}}">{{ route('activateuser',$user->activation_token)}}</a>
@endcomponent

Thanks,<br>
Web Admin
@endcomponent
