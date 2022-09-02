
@component('mail::message')
# Verify new Email

Your request to update email is processed , Please click on the below link to verify your email account

@component('mail::button', ['url' => $verifyUrl])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
