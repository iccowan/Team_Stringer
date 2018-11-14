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
    <div class="tabs is-centered is-boxed is-fullwidth">
        <ul>
            <li class="is-active"><a href="/coach/racquets-view">Waiting Requests</a></li>
            <li><a href="/coach/racquets-view?tab=done">Completed Requests</a></li>
        </ul>
    </div>
    <table class="table is-striped is-bordered is-fullwidth">
        <thead>
            <tr>
                <th>Player Name</th>
                <th>Racquet ID</th>
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
                        <td>{{ App\User::find($r->user_id)->name }}</td>
                        <td>{{ $r->id }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->manufacturer }} / {{ App\Racquet::find($r->racquet_id)->type }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->string }}
                        <td>{{ App\Racquet::find($r->racquet_id)->tension_lbs }}</td>
                        <td>{{ App\Racquet::find($r->racquet_id)->notes }}</td>
                        <td>{{ $r->request_date }}</td>
                        <td>
                            <a href="/coach/racquets/complete/{{ $r->id }}" class="button is-success" title="Set Request as Strung"><i class="fas fa-check"></i></a>
                            <a href="/coach/racquets/delete/{{ $r->id }}" class="button is-danger" title="Delete Request"><i class="fas fa-times"></i></a>
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

    @if($racquets_done->lastPage() == 1)
    @elseif($racquets_done->lastPage() < 4)
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
                        <a class="pagination-link" href="?tab=done&page={{ $racquets_done->lastPage() }}" title="Goto page {{ $racquets_done->lastPage() }}">{{ $racquets_done->lastPage() }}</a>
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
                    <a class="pagination-link" href="?tab=done&page={{ $racquets_done->lastPage() }}" title="Goto page {{ $racquets_done->lastPage() }}">{{ $racquets_done->lastPage() }}</a>
                </li>
            </ul>
        </nav>
    @elseif($racquets_done->lastPage() - 1 == $page)
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
        @elseif($racquets_done->lastPage() == $page)
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
    @elseif($racquets_done->lastPage() > 4)
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
                    <a class="pagination-link" href="?tab=done&page={{ $racquets_done->lastPage() }}" title="Goto page {{ $racquets_done->lastPage() }}">{{ $racquets_done->lastPage() }}</a>
                </li>
            </ul>
        </nav>
    @endif
</div>
@endsection
