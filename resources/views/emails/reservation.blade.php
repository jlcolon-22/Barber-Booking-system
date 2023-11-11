@component('mail::message')
# {{$data['message']}}

<span><h3>NAME:</h3>{{$data['name']}}</span>

<br>

<span><h3>EMAIL:</h3>{{$data['email']}}</span>

<br>

<span><h3>DATE:</h3>{{$data['date']}}</span>
<br>

<span><h3>Time:</h3>{{$data['time']}}</span>

@endcomponent
