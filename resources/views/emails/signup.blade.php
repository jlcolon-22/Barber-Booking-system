@component('mail::message')
# Verification


@component('mail::button', ['url' => $data['link']])
Click to verify your account!
@endcomponent


@endcomponent
