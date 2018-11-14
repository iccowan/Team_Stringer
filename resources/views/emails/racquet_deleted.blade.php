<!doctype html>
<body>
    <p>Dear {{ $player->name }},</p>
    <br>
    <p>The following racquet stringing request has been deleted by {{ $updater->name }}.</p>
    <p><b>ID:</b> {{ $request->id }}</p>
    <p><b>Racquet Information:</b> {{ $racquet->full_text }}</p>
    <p>If you would like to contact the person that has deleted your request, you can do this with the email: <a href="mailto:{{ $updater->email }}">{{ $updater->email }}</a>.</p>
    <br>
    <p><i>--End Message--</i></p>
</body>
