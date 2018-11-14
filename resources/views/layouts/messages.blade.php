<div class="container">
    @if(Session::has('success'))
        <div class="notification is-success">{{ Session::get('success') }}</div>
    @elseif(Session::has('error') || $errors->any())
        <div class="notification is-danger">
            {{ Session::get('error') }}
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
</div>
<br>