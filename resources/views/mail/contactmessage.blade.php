@component('mail::message')
The following message has been sent to xplore team.
# {{ $contact['name']}}'s message 

<b>Email :</b> {{ $contact['email'] }}<br>
<b>Phone :</b> {{ $contact['phone'] }}<br>
<b>Message :</b> {{ $contact['message'] }}


@endcomponent
