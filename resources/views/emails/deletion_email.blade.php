@component('mail::message')
Please confirm that you would like to delete your For Sale profile.

With the deletion of the profile you irreversibly remove all of your ads, message communications,
searches and history.

After your profile has been deleted, we will still be able to store your personal data for perposes and period
necessary for the execution of our duties required by law. Furthermore we will store and use data related to your profile
for protecting our lawful interests
(e. g. for the purpose of preventing fraud or creating, filing or defending legal claims).

@component('mail::button', ['url' => url(route('profile_deletion', $user_id))])
Confirm
@endcomponent

@endcomponent
