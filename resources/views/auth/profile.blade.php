@extends('layouts.master')
@section('title')
    Profile
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Profile for {{ $user->name }}</h1>
    </div>
    <br>
    {!! Form::open(['url' => '/profile/save/'.$user->id]) !!}
        <div class="columns">
            <div class="column">
                @if($user->role == "COACH")
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Name *</label>
                                <div class="control has-icons-left">
                                    {!! Form::text('name', $user->name, ['class' => 'input']) !!}
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Team Name *</label>
                                <div class="control has-icons-left">
                                    {!! Form::text('team_name', $user->team_name, ['class' => 'input']) !!}
                                    <span class="icon is-small is-left">
                                        <i class="fas fa-users"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="field">
                        <label class="label">Name *</label>
                        <div class="control has-icons-left">
                            {!! Form::text('name', $user->name, ['class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    {!! Form::hidden('team_name', $user->team_name) !!}
                @endif
                <div class="field">
                    <label class="label">Birthday <i>(YYYY-MM-DD)</i> *</label>
                    <div class="control has-icons-left">
                        {!! Form::text('birthday', $user->birthday, ['class' => 'input']) !!}
                        <span class="icon is-small is-left">
                            <i class="fas fa-calendar"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Enter Current Password to Save Changes *</label>
                    <div class="control has-icons-left">
                        {!! Form::password('current_password', ['placeholder' => 'Current Password', 'class' => 'input']) !!}
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="button is-primary">Save Changes</button>
            </div>
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Email *</label>
                            <div class="control has-icons-left">
                                {!! Form::email('email', $user->email, ['class' => 'input']) !!}
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">New Password</label>
                    <div class="control has-icons-left">
                        {!! Form::password('password', ['placeholder' => 'New Password', 'class' => 'input']) !!}
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Confirm New Password</label>
                    <div class="control has-icons-left">
                        {!! Form::password('password2', ['placeholder' => 'Confirm New Password', 'class' => 'input']) !!}
                        <span class="icon is-small is-left">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
    @if($user->role == "COACH")
        <hr>
        {!! Form::open(['url' => '/profile/update-plan/'.$user->id]) !!}
            @csrf

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Select New Plan</label>
                        <p><b>PLEASE NOTE:</b> You should change your plan close to your billing date. The changes will take effect immediately and the new charge will occur within 24 hours of the change REGARDLESS of an upgrade or downgrade.</p>
                        <br>
                        <div class="select">
                            {!! Form::select('plan', [
                                0 => 'Free ($0/mo)',
                                1 => 'Basic ($5/mo)',
                                2 => 'High School ($15/mo)',
                                3 => 'College ($25/mo)'
                            ], $user->account_type, ['class' => 'select']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Enter Current Password to Change Plan *</label>
                        <div class="control has-icons-left">
                            {!! Form::password('current_password', ['placeholder' => 'Current Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="button is-primary">Change Plan</button>
                </div>
                <div class="column">
                </div>
            </div>
        {!! Form::close() !!}
        <br>
        <p><b>Please note that:</b></p>
        <p>- A maximum of TWO plan changes per month are permitted.</p>
        <p>- Once a plan change is started, it must be completed or you will be redirected back and saved with a basic plan.</p>
        <p>- If you are found to be abusing the plan system, your account is subject to removal.</p>
        <p>- You should change your plan near the end of your current billing cycle. When changing plans, they will take effect immediately and begin chargining you within the next 24 hours.</p>
        <p>- When downgrading, extra players, coaches, and stringers will be removed AT RANDOM with the exception of you. Please make note of this as lost accounts cannot be recovered once the action takes place.</p>
        <p>- If you have any issues, feel free to email us at <a href="mailto:info@team-stringer.com">info@team-stringer.com</a>.</p>
    @elseif($user->role == 'STRING')
        <hr>
        {!! Form::open(['url' => '/profile/stringer-stats-set']) !!}
            <h2 class="title is-5">View Racquets Strung for a Set Month</h2>
            <h2 class="subtitle is-6"><i>Showing Stats for {{ $month }}/{{ $year }}</i></h2>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label">Month</label>
                        <div class="select">
                            {!! Form::select('month', [
                                1 => 'January',
                                2 => 'Febuary',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                            ], $month, ['class' => 'select']) !!}
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label">Year <i>(YYYY)</i></label>
                        <div class="control">
                            {!! Form::text('year', $year, ['class' => 'input']) !!}
                        </div>
                    </div>
                </div>
                <div class="column">
                </div>
                <div class="column">
                </div>
                <div class="column">
                </div>
                <div class="column">
                </div>
                <div class="column">
                </div>
                <div class="column">
                </div>
            </div>
            <p><b>Racquets Strung:</b> {{ $stringing_jobs }}</p>
            <br>
            <button class="button is-primary" type="submit">Submit</button>
        {!! Form::close() !!}
    @endif
</div>
@endsection
