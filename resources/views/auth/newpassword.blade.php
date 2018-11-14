@extends('layouts.master')

@section('title')
    Password Reset
@endsection

@section('content')
<div class="container">
    <div class="columns">
        <div class="column"></div>
        <div class="column">
            <div class="box">
                <h1 class="title is-3">Set New Password</h1>
                {!! Form::open(['AuthController@saveNewPassword']) !!}
                    @csrf

                    {!! Form::hidden('user_id', $user->id) !!}
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Verify Password</label>
                        <div class="control has-icons-left has-icons-right">
                            {!! Form::password('password2', ['placeholder' => 'Verify Password', 'class' => 'input']) !!}
                            <span class="icon is-small is-left">
                                <i class="fas fa-key"></i>
                            </span>
                        </div>
                    </div>
                    <button class="button is-success" type="submit">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>
@endsection