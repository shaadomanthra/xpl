
@component('mail::message')
# Hi {{$user['name']}}!, your payment was {{$order['payment_status']}}.


@component('mail::panel')
Order ID : <b>{{$order['order_id']}}</b><br>
Transaction Amount : <b>{{$order['txn_amount']}}</b><br>
Payment Status : <b>{{$order['payment_status']}}</b><br>
@endcomponent

Thanks,<br>
{{ env('APP_NAME') }}
@endcomponent
