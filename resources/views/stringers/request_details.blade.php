@extends('layouts.master')
@section('title')
    Request {{ $request->id }}
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Viewing Details for Stringing Request {{ $request->id }}</h1>
    </div>
    <br>
    <div class="box">
        <p><b>ID:</b> {{ $request->id }}</p>
        <p><b>Requester Name:</b> {{ App\User::find($request->user_id)->name }}</p>
        <p><b>Manufacturer:</b> {{ App\Racquet::find($request->racquet_id)->manufacturer }}</p>
        <p><b>Type:</b> {{ App\Racquet::find($request->racquet_id)->type }}</p>
        <p><b>Tension (LBS):</b> {{ App\Racquet::find($request->racquet_id)->tension_lbs }}</p>
        <p><b>String:</b> {{ App\Racquet::find($request->racquet_id)->string }}</p>
        <p><b>Additional Notes:</b> {{ App\Racquet::find($request->racquet_id)->notes }}</p>
        <br>
        <a href="/stringer/team-string-requests" class="button is-info"><i class="fas fa-arrow-left"></i>&nbsp;Back</a>
        <a href="/stringer/team-string-requests/complete/{{ $request->id }}" class="button is-success" title="Set Request as Strung">Set Request as Complete</a>
    </div>
</div>
@endsection
