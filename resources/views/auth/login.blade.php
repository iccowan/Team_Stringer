@extends('layouts.master')

@section('title')
    Login
@endsection

@section('content')
<div class="container">
    <div class="columns">
        <div class="column"></div>
        <div class="column">
            <div class="box">
                <h1 class="title is-3">Registered User Login</h1>
                {!! Form::open(['AuthController@loginUser']) !!}
                    @csrf

                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control has-icons-left">
                            {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            {!! Form::checkbox('remember', '1') !!}
                            Remember Me?
                        </label>
                    </div>
                    <button class="button is-success" type="submit">Login</button>
                    <a class="button is-warning" href="/password-reset">Forgot Password?</a>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>
@endsection