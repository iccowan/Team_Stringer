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
                <h1 class="title is-3">Set a New Password</h1>
                {!! Form::open(['AuthController@requestPasswordReset', $token]) !!}
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
                    <button class="button is-success" type="submit">Submit</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column"></div>
    </div>
</div>
@endsection