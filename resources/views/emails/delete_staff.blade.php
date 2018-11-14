<!doctype html>
<body>
    <p>Dear {{ $staff->name }},</p>
    <br>
    <p>You have been removed from the staff list by {{ $user->name }}. If you have any questions or would like to know why this has occured, please send an email to <a href="mailto:info@team-stringer.com">info@team-stringer.com</a>.</p>
    <br>
    <p><i>--End Message--</i></p>
</body>