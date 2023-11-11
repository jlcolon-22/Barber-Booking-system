@component('mail::message')
# Reset Password


@component('mail::button', ['url' => $data['link']])
Click to verify your account!
@endcomponent


@endcomponent
