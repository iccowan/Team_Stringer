@extends('layouts.master')
@section('title')
    New Racquet
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">New Racquet</h1>
    </div>
    <br>
    {!! Form::open(['RosterController@saveNewRacquet']) !!}
        @csrf

        <div class="columns">
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Manufacturer *</label>
                            <div class="control">
                                {!! Form::text('manu', null, ['placeholder' => 'Manufacturer', 'class' => 'input']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Type *</label>
                            <div class="control">
                                {!! Form::text('type', null, ['placeholder' => 'Type', 'class' => 'input']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Tension (LBS) *</label>
                    <div class="control">
                        {!! Form::text('tension', null, ['placeholder' => 'Tension (LBS)', 'class' => 'input']) !!}
                    </div>
                </div>
                <button type="submit" class="button is-primary">Add Racquet</button>
            </div>
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">String *</label>
                            <div class="control">
                                {!! Form::text('string', null, ['placeholder' => 'String', 'class' => 'input']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Notes (Will be seen by stringers and coach)</label>
                        <div class="control">
                            {!! Form::text('notes', null, ['placeholder' => 'Notes', 'class' => 'input']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection
