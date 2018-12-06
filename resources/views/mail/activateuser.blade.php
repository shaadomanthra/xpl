
@component('mail::message')
# Hi {{$user['name']}}!, Welcome to PacketPrep.

Your registered email-id is {{$user['email']}} <br>

@component('mail::panel')
Username : <b>{{$user['username']}}</b><br>
Password : <b>{{$user['password']}}</b><br>
Url : <a href="https://packetprep.com">packetprep.com</a>
@endcomponent

Thanks,<br>
PacketPrep
@endcomponent
