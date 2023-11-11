@component('mail::message')
# Contact Form

<span><h3>NAME:</h3>{{$data['name']}}</span>

<br>

<span><h3>EMAIL:</h3>{{$data['email']}}</span>

<br>

<span><h3>MESSAGE:</h3>{{$data['message']}}</span>
@endcomponent
