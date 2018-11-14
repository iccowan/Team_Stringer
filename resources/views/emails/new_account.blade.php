<!doctype html>
<body>
    <p>Dear {{ $user->name }},</p>
    <br>
    <p>Welcome to Team Stringer! You have been registered successfully! In order to begin using Team Stringer, please continue to the <a href="https://www.team-stringer.com/coach/roster-manage" target="_blank">roster management page</a> to begin adding players and stringers!</p>
    <p>I hope you will find Team Stringer useful and if you have any questions or concerns on how to begin, please do not hesitate to <a href="mailto:info@team-stringer.com">contact us</a>!</p>
    <br>
    <p>Plan Details:</p>
    <p><b>Plan Name:</b>
        @if($user->account_type == 0)
            Free ($0/mo)
        @elseif($user->account_type == 1)
            Basic ($5/mo)
        @elseif($user->account_type == 2)
            High School ($15/mo)
        @elseif($user->account_type == 3)
            College ($25/mo)
        @else
            Your plan was not saved correctly. Please forward this to <a href="mailto:info@team-stringer.com">info@team-stringer.com</a> to correct the issue.
        @endif
    </p>
    <p><b>Registered Email:</b> {{ $user->email }}</p>
    <br>
    <p>Please remember that Team Stringer is still in an early testing stage and that all bug reports are greatly appreciated! Enjoy and let us know if you have any issues!</p>
    <br>
    <p>Sincerely,</p>
    <p>Team Stringer Staff Team</p>
    <br>
    <p><i>If you have not registered for Team Stringer, please forward this email with an explanation immediately to <a href="mailto:info@team-stringer.com">inf@team-stringer.com</a> in order to correct the issue.</i></p>
    <br>
    <p><i>--End Message--</i></p>
</body>
