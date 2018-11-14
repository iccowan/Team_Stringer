@extends('layouts.master')
@section('title')
    My Stringing Requests
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">My Stringing Requests</h1>
    </div>
    <br>
    <div class="columns">
        <div class="column">
            {!! Form::open(['StringingController@saveNewStringRequest']) !!}
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <div class="select is-fullwidth">
                            {!! Form::select('racquet', $racquets, null, ['placeholder' => 'Select Racquet', 'class' => 'select']) !!}
                        </div>
                    </div>
                    <div class="control">
                        <button class="button is-success" type="submit">Create Stringing Request</button>
                    </div>
                </div>
            {!! Form::close() !!}
            <a href="/player/my-racquets"><p><i>No racquets? Add one here!</i></p></a>
        </div>
        <div class="column">
        </div>
    </div>
    <br>
    <div class="tabs is-centered is-boxed is-fullwidth">
        <ul>
            <li class="is-active"><a href="/player/my-string-requests">Waiting Requests</a></li>
            <li><a href="/player/my-string-requests?tab=done">Completed Requests</a></li>
        </ul>
    </div>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Stringing ID</th>
                <th>Racquet Manufacturer/Type</th>
                <th>String</th>
                <th>Tension (LBS)</th>
                <th>Notes</th>
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($racquets_wait->count() > 0)
                @foreach($racquets_wait as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->manufacturer }} / {{ App\Racquet::find($r->racquet_id)->type }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->string }}
                        <td>{{ App\Racquet::find($r->racquet_id)->tension_lbs }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->notes }}</td>
                        <td>{{ $r->request_date }}</td>
                        <td>
                            <a class="button is-danger" href="/player/my-string-requests/delete/{{ $r->id }}"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
            @else
        </tbody>
    </table>
                <p>No racquets waiting to be strung for {{ Auth::user()->name }}.</p>
            @endif
</div>
@endsection
