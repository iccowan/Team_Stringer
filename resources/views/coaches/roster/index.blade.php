@extends('layouts.master')
@section('title')
    Manage Team Roster
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Manage Team Roster</h1>
    </div>
    <br>
    <a href="/coach/roster-manage/new" class="button is-info">Add New Player/Coach</a>
    <br><br>
    <h2 class="title is-5">Coaches</h2>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Invite Accepted?</th>
                <th>Options</th>
            </tr>
        </thead>
            <tbody>
                @foreach($coaches as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td><a href="mailto:{{ $c->email }}">{{ $c->email }}</a></td>
                        <td>
                            @if($c->password == 'NOT YET ACCEPTED INVITE')
                                No
                            @else
                                Yes
                            @endif
                        <td>
                            @if($c->id == Auth::user()->id || Auth::user()->plan_id == null)
                                <p><i>You are not permitted to remove this coach.</i></p>
                            @else
                                {!! Form::open(['url' => '/coach/roster-manage/save-player/'.$c->id]) !!}
                                    @csrf
                                    {!! Form::hidden('option', 0) !!}
                                        <div class="control is-centered">
                                            <button type="submit" class="button is-danger">Remove as Coach</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <hr>
    <h2 class="title is-5">Players</h2>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Stringer?</th>
                <th>Stringing Requests</th>
                <th>Invite Accepted?</th>
                <th>Options</th>
            </tr>
        </thead>
        @if($players->count() > 0)
            <tbody>
                @foreach($players as $p)
                    <tr>
                        <td>{{ $p->name }}</td>
                        <td><a href="mailto:{{ $p->email }}">{{ $p->email }}</a></td>
                        <td>
                            @if($p->role == 'STRING')
                                Yes
                            @else
                                No
                            @endif
                        </td>
                        <td>{{ $p->string_count }}</td>
                        <td>
                            @if($p->password == 'NOT YET ACCEPTED INVITE')
                                No
                            @else
                                Yes
                            @endif
                        <td>
                            {!! Form::open(['url' => '/coach/roster-manage/save-player/'.$p->id]) !!}
                                @csrf
                                @if($p->role == 'STRING')
                                <div class="field has-addons">
                                    <div class="control is-expanded">
                                        <div class="select is-fullwidth">
                                            {!! Form::select('option', [
                                                0 => 'Remove from Roster',
                                                1 => 'Remove as Stringer'
                                            ], null, ['placeholder' => 'Select One', 'class' => 'input']) !!}
                                        </div>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-primary">Submit</button>
                                    </div>
                                </div>
                                @else
                                    <div class="field has-addons">
                                        <div class="control is-expanded">
                                            <div class="select is-fullwidth">
                                                {!! Form::select('option', [
                                                    0 => 'Remove from Roster',
                                                    1 => 'Set as Stringer'
                                                ], null, ['placeholder' => 'Select One', 'class' => 'input']) !!}
                                            </div>
                                        </div>
                                        <div class="control">
                                            <button type="submit" class="button is-primary">Submit</button>
                                        </div>
                                    </div>
                                @endif
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        </table>
            No players on roster.
        @endif
</div>
@endsection
