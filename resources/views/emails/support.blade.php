<!doctype html>
<body>
    <p>New message received from {{ $name }} at {{ $time }}.</p>
    <br>
    <p><b>Name:</b> {{ $name }}</p>
    <br>
    <p><b>Email Address:</b> {{ $email }}</p>
    <br>
    <p><b>Reason for Inquiry:</b> @if($reason == 1) General Questions @elseif($reason == 2) Billing @elseif($reason == 3) Plans @elseif($reason == 4) Bug or Another Online Issue @else Other @endif</p>
    <br>
    <p><b>Message Content:</b></p>
    <p>{!! nl2br(e($content)) !!}</p>
    <br>
    <p><i>--End Message--</i></p>
</body>
