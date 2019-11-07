
@component('mail::message')
# Hi {{$user['name']}}!, your payment was {{$order['payment_status']}}.


@component('mail::panel')
Order ID : <b>{{$order['order_id']}}</b><br>
Transaction Amount : <b>{{$order['txn_amount']}}</b><br>
Payment Status : <b>{{$order['payment_status']}}</b><br>
@endcomponent

In case of any query kindly <a href="{{route('contact-corporate')}}">contact</a> our admin team.<br><br>
Thanks,<br>
Xplore
@endcomponent
