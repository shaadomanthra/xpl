
@component('mail::message')
# Hi {{$user['name']}}!, 

PacketPrep is organizing CODING BOOTCAMP - A Summer Internship Certificate Program. <br>

Through this program, you will build your first commercial web application. It is a great opportunity for you to utilize this summer to build a great realtime project, where you will learn to write code from scratch to the end.<br>

All participants will get Internship Certificate.<br>
@component('mail::panel')
Reach out to your campus ambassador for Rs.1000 discount coupon. Or whatsapp us at +91 95151 25110 or email us at founder@packetprep.com for the coupon.<br>
@endcomponent

@component('mail::button', ['url' => 'http://bit.ly/2K8eTAH'])
Bootcamp Details
@endcomponent


Thanks,<br>
PacketPrep
@endcomponent
