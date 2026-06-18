<x-mail::message>
# Verification Code

Your verification code is:

<x-mail::panel>
# {{ $code }}
</x-mail::panel>

This code expires in **1 hour**.

Thanks,
{{ config('app.name') }}
</x-mail::message>
