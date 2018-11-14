@extends('layouts.master')
@section('title')
    Manage Coach Accounts
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Manage Coach Accounts</h1>
    </div>
    <br>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Team Name</th>
                <th>Coach Name</th>
                <th>Coach Email</th>
                <th>Plan</th>
                <th>Member Since</th>
                <th># of Players</th>
                <th>Last Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coach as $c)
                <tr>
                    <td><a href="/staff/coach/view-team/{{ $c->id }}" title="More Team Details">{{ $c->team_name }}</a></td>
                    <td>{{ $c->name }}</td>
                    <td><a href="mailto:{{ $c->email }}">{{ $c->email }}</a></td>
                    <td>{{ $c->plan_name }}</td>
                    <td>{{ $c->created_at }}</td>
                    <td>{{ $c->player_number }}</td>
                    <td>{{ $c->last_payment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
