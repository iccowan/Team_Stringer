@extends('layouts.master')
@section('title')
    New Staff Member
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">New Staff Member</h1>
    </div>
    <br>
    {!! Form::open(['StaffController@saveNewStaff']) !!}
        @csrf

        <div class="columns">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">First Name *</label>
                            <div class="control">
                                {!! Form::text('fname', null, ['placeholder' => 'First Name', 'class' => 'input']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Last Name *</label>
                            <div class="control">
                                {!! Form::text('lname', null, ['placeholder' => 'Last Name', 'class' => 'input']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Birthday <i>(YYYY-MM-DD)</i> *</label>
                    <div class="control">
                        {!! Form::text('birthday', null, ['placeholder' => 'Birthday (YYYY-MM-DD)', 'class' => 'input']) !!}
                    </div>
                </div>
                <button type="submit" class="button is-primary">Add Staff Member</button>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Email *</label>
                    <div class="control has-icons-left">
                        {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'input']) !!}
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection
