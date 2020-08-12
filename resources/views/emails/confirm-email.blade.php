@component('mail::message')
# Final Step

Please confirm your email to be able to use the full functionality of the platform.

@component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
