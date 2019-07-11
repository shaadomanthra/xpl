@component('mail::message')
# Job Applicant Alert

<b>{{ $form['name'] }}</b> has applied for <b>{{ $form->job->title }}</b>.<br>
Email : {{ $form['email'] }} <br>
Phone : {{ $form['phone'] }} <br>

@component('mail::button', ['url' => route('form.show',$form['id'])])
View Applicant
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
