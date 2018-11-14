<!doctype html>
<body>
    <p>Dear {{ $name }},</p>
    <br>
    <p>You have requested a link to reset your password for Team Stringer. Please use the link below to complete this action.</p>
    <a href="https://www.team-stringer.com/reset-password/{{ $token }}">https://www.team-stringer.com/password-reset/{{ $token }}</a>
    <p>If the link does not work, please copy and paste the link directly into your browser. If you did not request this action, please send an email immediately to <a href="mailto:info@team-stringer.com">info@team-stringer.com</a>.</p>
    <p>Please know that your token will expire in 10 minutes from the request. If your token expires, please just request a new one.</p>
    <br>
    <p><i>--End Message--</i></p>
</body>
