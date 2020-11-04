@component('mail::message')
You have received a new message concerning your ad "{{ $adTitle }}".

To view it, visit your message center:

@component('mail::button', ['url' => url('/myaccount/messages'), 'color' => 'success'])
To My Profile Panel
@endcomponent

See you soon,<br>
{{ config('app.name') }}
@endcomponent
