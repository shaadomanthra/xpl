
@component('mail::message')
# Hi {{$user['name']}}!, Welcome to PacketPrep.

Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account.

@component('mail::button', ['url' => url('user/activate', $user->activation_token)])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
