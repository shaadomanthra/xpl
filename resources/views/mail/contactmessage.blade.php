@component('mail::message')
The following message has been sent to packetprep team.
# {{ $contact['name']}}'s message 

<b>Email :</b> {{ $contact['email'] }}<br>
<b>Subject :</b> {{ $contact['subject'] }}<br>
<b>Message :</b> {{ $contact['message'] }}


@endcomponent
