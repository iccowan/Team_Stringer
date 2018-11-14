@extends('layouts.master')
@section('title')
    Details for {{ $coach->team_name }} Team
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Showing Details for {{ $coach->team_name }} Team</h1>
    </div>
    <br>
    <div class="columns">
        <div class="column">
            <h2 class="title is-4">Roster</h2>
            <table class="table is-striped is-bordered is-fullwidth">
                <thead>
                    <tr>
                        <th>Player Name</th>
                        <th>Player Email</th>
                        <th>Stringer?</th>
                    </tr>
                </thead>
                <tbody>
                    @if($players->count() > 0)
                        @foreach($players as $p)
                            <tr>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->email }}</td>
                                <td>
                                    @if($p->role == 'STRING')
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
                    @else
                </tbody>
            </table>
                        No Players on Roster.
                    @endif
        </div>
        <div class="column">
            {!! Form::open(['StaffController@manageCoach', $coach->id]) !!}
                @csrf

                <div class="field is-grouped is-grouped-right">
                    <div class="select">
                        {!! Form::select('option', [
                            1 => 'Upgrade Plan 1 Tier',
                            2 => 'Downgrade Plan 1 Tier',
                            3 => 'Cancel Plan / Set Plan to Free',
                            4 => 'Remove Coach/Team'
                        ], null, ['placeholder' => 'Select One', 'class' => 'select']) !!}
                    </div>
                    &nbsp;
                    <div class="control">
                        <button type="submit" class="button is-primary">Submit</button>
                    </div>
                </div>
            {!! Form::close() !!}
            <h2 class="title is-4">Plan</h2>
            <p>{{ $coach->plan_name }}</p>
            <hr>
            <h2 class="title is-4">Last Payment</h2>
            <p>{{ $coach->last_payment }}</p>
            <hr>
            <h2 class="title is-4">Coach Contact Information</h2>
            <p><b>Email:</b> <a href="mailto:{{ $coach->email }}">{{ $coach->email }}</a></p>
        </div>
    </div>
</div>
@endsection
