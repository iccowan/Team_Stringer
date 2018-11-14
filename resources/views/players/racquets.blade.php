@extends('layouts.master')
@section('title')
    My Racquets
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">My Racquets</h1>
    </div>
    <br>
    <a href="/player/my-racquets/new" class="button is-info">Add New Racquet</a>
    <br><br>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Manufacturer/Type</th>
                <th>Tension (LBS)</th>
                <th>String</th>
                <th>Notes</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @if($racquets->count() > 0)
                @foreach($racquets as $r)
                    <tr>
                        <td>{{ $r->manufacturer }} / {{ $r->type }}</td>
                        <td>{{ $r->tension_lbs }}</td>
                        <td>{{ $r->string }}</td>
                        @if($r->notes != null)
                            <td>{{ $r->notes }}</td>
                        @else
                            <td>None</td>
                        @endif
                        <td>
                            <a href="/player/my-racquets/edit/{{ $r->id }}" class="button is-success" title="Edit Racquet"><i class="fas fa-pencil-alt"></i></a>
                            <a href="/player/my-racquets/delete/{{ $r->id }}" class="button is-danger" title="Delete Racquet"><i class="fas fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
            @else
        </tbody>
    </table>
                <p>No racquets found for {{ Auth::user()->name }}</p>
            @endif
</div>
@endsection
