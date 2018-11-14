@extends('layouts.master')

@section('title')
    Register
@endsection

@section('content')
<div class="container">
    <div class="columns">
        <div class="column"></div>
        <div class="column">
            <div class="box">
                <h1 class="title is-3">New Coach Registration</h1>
                {!! Form::open(['LoginController@loginUser']) !!}
                    @csrf

                    <div class="field">
                        <label class="label">First Name *</label>
                        <div class="control">
                            {!! Form::text('fname', null, ['placeholder' => 'First Name', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Last Name *</label>
                        <div class="control">
                            {!! Form::text('lname', null, ['placeholder' => 'Last Name', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Birthday <i>(DD/MM/YYYY)</i> *</label>
                        <div class="control">
                            {!! Form::text('birthday', null, ['placeholder' => 'DD/MM/YYYY', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Team/School Name *</label>
                        <div class="control">
                            {!! Form::text('team_name', null, ['placeholder' => 'Team/School Name', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email *</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password *</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Verify Password *</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::password('password2', ['placeholder' => 'Verify Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Plan *</label>
                        <div class="select">
                            {!! Form::select('plan', [
                                0 => 'Free ($0/mo)',
                                1 => 'Basic ($5/mo)',
                                2 => 'High School ($15/mo)',
                                3 => 'College ($25/mo)'
                            ], $plan, ['class' => 'select']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            {!! Form::checkbox('terms', '1') !!}
                            I have read and agree to the <a href="/terms-of-service">Terms of Service</a> *
                        </label>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6Lf2uHUUAAAAAO8HMK2l0firYKpFY7zmJwUHPqQr"></div>
                    <br>
                    <button class="button is-success" type="submit">Register</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>
@endsection
