@component('mail::message')

# Hello {{$user->person->first_name}},

Your TaxitManager account has been setup and your login details are as follows.

* Email : {{$user->email}}
* Password : password

Click the button below to login and ensure you change your password.

@component('mail::button', ['url' => '/dashboard'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
