<!doctype html>
<body>
    <p>Dear {{ $player->name }},</p>
    <br>
    <p>The following racquet stringing request has been marked as completed by {{ $updater->name }}! It is ready as of now at your designated pickup spot.</p>
    <p><b>ID:</b> {{ $request->id }}</p>
    <p><b>Racquet Information:</b> {{ $racquet->full_text }}</p>
    <p>If you need to contact the person that strung your racquet, you can do this with the email: <a href="mailto:{{ $updater->email }}">{{ $updater->email }}</a>.</p>
    <br>
    <p><i>--End Message--</i></p>
</body>
