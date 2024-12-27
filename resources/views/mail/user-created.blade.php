<x-mail::message>
    Dear {{$user->name }},

    We are pleased to inform you that your account has been successfully created.
    Please find your login credentials
    below:

    - Email: {{$user->email }}
    - Password: {{ $defaultPassword }}

    For your security, we recommend resetting your password immediately after logging in.
    You can do this easily by
    navigating to the profile section.

    Log in here: {{url('/login')}}.

    Best regards,
    {{ config('app.name') }}
</x-mail::message>