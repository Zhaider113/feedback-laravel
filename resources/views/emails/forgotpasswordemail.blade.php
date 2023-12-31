@component('mail::message')
# Reset Password

You are receiving this email because we received a password reset request for your account.
Click on link below to reset your Password.
<br>

<a href = "{{ $code }}">Reset Password</a>

Thanks,<br>
{{ $pr }}
@endcomponent
