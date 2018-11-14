<!doctype html>
<body>
    <p>Dear {{ $user->name }},</p>
    <br>
    <p>You have been invited by Ian Cowan to join the staff team at Team Stringer! Please follow the steps below to finish setting up your account.</p>
    <br>
    <p>Your registered name is: {{ $user->name }}</p>
    <p>Your registered email is: {{ $user->email }}</p>
    <p>You have been registered for: {{ $user->team_name }}</p>
    <p>If any of this information appears to be incorrect, but you would still like to accept this invite, continue with the instructions below. Once you have registered and are logged in, you can edit this information from the profile page.</p>
    <br>
    <p>If you believe you have received this email in error, please send an email to <a href="mailto:info@team-stringer.com">info@team-stringer.com</a> to be removed completely from our system.</p>
    <p>If you would like to continue with registration, please continue to <a href="https://www.team-stringer.com/password-reset">https://www.team-stringer.com/password-reset</a> and follow the instructions in order to set a password. Please note that by clicking this link and continuing with registration, you are agreeing to our <a href="https://www.team-stringer.com/terms-of-service">Terms of Service which can be found here.</a> If you do not agree with these terms, please send an email to <a href="mailto:info@team-stringer.com">info@team-stringer.com</a> immediately in order to be removed completely from our system.</p>
    <p>Once you have registered, please continue to <a href="https://www.team-stringer.com/login">https://www.team-stringer.com/login</a> to login for the first time and get started!</p>
    <br>
    <p><i>--End Message--</i></p>
</body>
