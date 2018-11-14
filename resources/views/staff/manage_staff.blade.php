@extends('layouts.master')
@section('title')
    Manage Staff Members
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Manage Staff Members</h1>
    </div>
    <br>
    <a href="/staff/staff-manage/new" class="button is-info">Add New Staff Member</a>
    <br><br>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Staff Member Since</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staff as $s)
                <tr>
                    <td>{{ $s->name }}</td>
                    <td><a href="mailto:{{ $s->email }}">{{ $s->email }}</a></td>
                    <td>{{ $s->created_at }}</td>
                    <td>
                        {!! Form::open(['url' => '/staff/staff-manage/manage/'.$s->id]) !!}
                            @csrf

                            <div class="field has-addons">
                                <div class="control is-expanded">
                                    <div class="select is-fullwidth">
                                        {!! Form::select('option', [
                                            0 => 'Remove'
                                        ], null, ['placeholder' => 'Select One', 'class' => 'input']) !!}
                                    </div>
                                </div>
                                <div class="control">
                                    <button type="submit" class="button is-primary">Submit</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection