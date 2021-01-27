@component('mail::message')
This is an email to let you know that an ad you keep an eye on has just lowered its price!

@component('mail::panel')
{{ $ad->title }}'s new price:
{{ $ad->price }}

@component('mail::button', ['url' => url($ad->path())])
Check it Out!
@endcomponent
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
