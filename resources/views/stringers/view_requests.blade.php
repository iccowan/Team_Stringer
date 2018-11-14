@extends('layouts.master')
@section('title')
    Team Stringing Requests
@endsection

@section('content')
<div class="container">
    <div class="box">
        <h1 class="title">Team Stringing Requests</h1>
    </div>
    <br>
            {!! Form::open(['url' => '/stringer/team-string-requests/search']) !!}
                <div class="field has-addons">
                    <div class="control">
                        {!! Form::text('search_params', null, ['placeholder' => 'View Racquet by ID', 'class' => 'input']) !!}
                    </div>
                    <div class="control">
                        <button class="button is-primary" type="submit">Go</button>
                    </div>
                </div>
            {!! Form::close() !!}
    <br>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Player Name</th>
                <th>Racquet Manufacturer/Type</th>
                <th>String</th>
                <th>Tension (LBS)</th>
                <th>Notes</th>
                <th>Date Requested</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($racquets->count() > 0)
                @foreach($racquets as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ App\User::find($r->user_id)->name }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->manufacturer }} / {{ App\Racquet::find($r->racquet_id)->type }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->string }}
                        <td>{{ App\Racquet::find($r->racquet_id)->tension_lbs }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->notes }}</td>
                        <td>{{ $r->request_date }}</td>
                        <td>
                            <a href="/stringer/team-string-requests/complete/{{ $r->id }}" class="button is-success" title="Set Request as Strung"><i class="fas fa-check"></i></a>
                            <a href="/stringer/team-string-requests/view-details/{{ $r->id }}" class="button is-primary" title="View Details"><i class="fas fa-eye"></i></a>
                        </td>
                    </tr>
                @endforeach
        </tbody>
    </table>
            @else
        </tbody>
    </table>
                <p>No racquets waiting to be strung.</p>
            @endif

    @if($racquets->lastPage() == 1)
    @elseif($racquets->lastPage() < 4)
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
            <a class="pagination-previous" href="?tab=done&page={{ $page - 1 }}">Previous</a>
            <a class="pagination-next" href="?tab=done&page={{ $page + 1 }}">Next page</a>
        </nav>
    @elseif($page == 2)
            <nav class="pagination is-small" role="navigation" aria-label="pagination">
                <a class="pagination-previous" href="?tab=done&page={{ $page - 1 }}">Previous</a>
                <a class="pagination-next" href="?tab=done&page={{ $page + 1 }}">Next page</a>
                <ul class="pagination-list">
                    <li>
                        <a class="pagination-link" href="?tab=done&page=1" title="Goto page 1">1</a>
                    </li>
                    <li>
                        <a class="pagination-link is-current" title="Page 2" title="Go to page">2</a>
                    </li>
                    <li>
                        <a class="pagination-link" href="?tab=done&page=3" title="Goto page 3">3</a>
                    </li>
                    <li>
                        <span class="pagination-ellipsis">&hellip;</span>
                    </li>
                    <li>
                        <a class="pagination-link" href="?tab=done&page={{ $racquets->lastPage() }}" title="Goto page {{ $racquets->lastPage() }}">{{ $racquets->lastPage() }}</a>
                    </li>
                </ul>
            </nav>
    @elseif($page == 1 || $page == null)
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
            <a class="pagination-next" href="?tab=done&page={{ $page + 1 }}">Next page</a>
            <ul class="pagination-list">
                <li>
                    <a class="pagination-link is-current" title="Page 1">1</a>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page=2" title="Page 2">2</a>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page=3" title="Goto page 3">3</a>
                </li>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page={{ $racquets->lastPage() }}" title="Goto page {{ $racquets->lastPage() }}">{{ $racquets->lastPage() }}</a>
                </li>
            </ul>
        </nav>
    @elseif($racquets->lastPage() - 1 == $page)
            <nav class="pagination is-small" role="navigation" aria-label="pagination">
                <a class="pagination-previous" href="?tab=done&page={{ $page - 1 }}">Previous</a>
                <a class="pagination-next" href="?tab=done&page={{ $page + 1 }}">Next page</a>
                <ul class="pagination-list">
                    <li>
                        <a class="pagination-link" href="?tab=done&page=1" title="Goto page 1">1</a>
                    </li>
                    <li>
                        <span class="pagination-ellipsis">&hellip;</span>
                    </li>
                    <li>
                        <a class="pagination-link" href="?tab=done&page={{ $page - 1 }}" title="Goto page {{ $page - 1 }}">{{ $page - 1 }}</a>
                    </li>
                    <li>
                        <a class="pagination-link is-current" title="Page {{ $page }}">{{ $page }}</a>
                    </li>
                    <li>
                        <a class="pagination-link" href="?tab=done&page={{ $page + 1 }}" title="Goto page {{ $page + 1 }}"> {{ $page + 1 }}</a>
                    </li>
                </ul>
            </nav>
        @elseif($racquets->lastPage() == $page)
            <nav class="pagination is-small" role="navigation" aria-label="pagination">
                <a class="pagination-previous" href="?tab=done&page={{ $page - 1 }}">Previous</a>
                <ul class="pagination-list">
                    <li>
                        <a class="pagination-link" href="?tab=done&page=1" title="Goto page 1">1</a>
                    </li>
                    <li>
                        <span class="pagination-ellipsis">&hellip;</span>
                    </li>
                    <li>
                        <a class="pagination-link" href="?tab=done&page={{ $page - 1 }}" title="Goto page {{ $page - 1 }}">{{ $page - 1 }}</a>
                    </li>
                    <li>
                        <a class="pagination-link is-current" title="Page {{ $page }}" >{{ $page }}</a>
                    </li>
                </ul>
            </nav>
    @elseif($racquets->lastPage() > 4)
        <nav class="pagination is-small" role="navigation" aria-label="pagination">
            <a class="pagination-previous" href="?tab=done&page={{ $page - 1 }}">Previous</a>
            <a class="pagination-next" href="?tab=done&page={{ $page + 1 }}">Next page</a>
            <ul class="pagination-list">
                <li>
                    <a class="pagination-link" href="?tab=done&page=1" title="Goto page 1">1</a>
                </li>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page={{ $page - 1 }}" title="Goto page {{ $page - 1 }}">{{ $page - 1 }}</a>
                </li>
                <li>
                    <a class="pagination-link is-current" title="Page {{ $page }}">{{ $page }}</a>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page={{ $page + 1 }}" title="Goto page {{ $page + 1 }}"> {{ $page + 1 }}</a>
                </li>
                <li>
                    <span class="pagination-ellipsis">&hellip;</span>
                </li>
                <li>
                    <a class="pagination-link" href="?tab=done&page={{ $racquets->lastPage() }}" title="Goto page {{ $racquets->lastPage() }}">{{ $racquets->lastPage() }}</a>
                </li>
            </ul>
        </nav>
    @endif
</div>
@endsection
