@component('mail::message')
# {{$user['name']}} downloaded '{{$customer['company']}}'coupon.


@component('mail::panel')
Name : <b>{{$user['name']}}</b><br>
Email :  {{$user['email']}} <br>
Phone : <b>{{$user['phone']}}</b><br>
College : {{$user['college']}}<br>
Branch : {{$user['branch']}}<br>
Year of Passing : {{$user['year_of_passing']}}<br>
Referral  : <b>{{$customer['referral']}}</b><br>
@endcomponent

<br>
regards,<br>
PacketPrep
@endcomponent