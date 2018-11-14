@extends('layouts.master')
@section('title')
    Home
@endsection

@section('content')
<div class="container">
    <center><h1 class="title">Welcome to Team Stringer!</h1></center>
    <br>
    <center><h2 class="subtitle"><i>The Easiest Way to Manage Tennis Racket Stringing</i></h4></center>
    <br>
    <div class="content">
        <center>
            <p>Tennis Stringer was designed by a college tennis team stringer for one reason: to simplify the process of getting tennis rackets strung efficiently and correctly. The Tennis Stringer online tool will definitely do this for you whether you're a club team or a division 1 college team! If you have any questions or would like to know how to get started, please see the support page. Now let's get stringing!</p>
        </center>
    </div>
    <hr>
    <center><h1 class="title is-4"><i>How it Works</i></h1></center>
    <br>
    <i>Video Coming Soon!</i>
    </br>
    <hr>
    <center><h1 class="title is-4"><i>Choose From One of Our Plans to Begin!</i></h1></center>
    <br>
    <div class="columns">
        <div class="column">
            <center>
                <div class="box">
                    <div class="content">
                        <h1 class="title is-5">Free Plan</h1>
                        <h2 class="subtitle is-6"><i>$0/mo</i></h2>
                        <ul>
                            <li>1 Coach</li>
                            <li>10 Players</li>
                            <li>1 Stringer</li>
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->role == 'COACH')
                            <a class="button is-primary" href="/profile" rel="nofollow">Downgrade</a>
                        @endif
                    @elseif(Auth::guest())
                        <a class="button is-primary" href="/register/0" rel="nofollow">Join Now!</a>
                    @endif
                </div>
            </center>
        </div>
        <div class="column">
            <center>
                <div class="box">
                    <div class="content">
                        <h1 class="title is-5">Basic Plan</h1>
                        <h2 class="subtitle is-6"><i>$5/mo</i></h2>
                        <ul>
                            <li>2 Coaches</li>
                            <li>15 Players</li>
                            <li>2 Stringers</li>
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->role == 'COACH')
                            <a class="button is-primary" href="/profile" rel="nofollow">Upgrade Now!</a>
                        @endif
                    @elseif(Auth::guest())
                        <a class="button is-primary" href="/register/1" rel="nofollow">Join Now!</a>
                    @endif
                </div>
            </center>
        </div>
        <div class="column">
            <center>
                <div class="box">
                    <div class="content">
                        <h1 class="title is-5">High School Plan</h1>
                        <h2 class="subtitle is-6"><i>$15/mo</i></h2>
                        <ul>
                            <li>4 Coaches</li>
                            <li>20 Players</li>
                            <li>4 Stringers</li>
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->role == 'COACH')
                            <a class="button is-primary" href="/profile" rel="nofollow">Upgrade Now!</a>
                        @endif
                    @elseif(Auth::guest())
                        <a class="button is-primary" href="/register/2" rel="nofollow">Join Now!</a>
                    @endif
                </div>
            </center>
        </div>
        <div class="column">
            <center>
                <div class="box">
                    <div class="content">
                        <h1 class="title is-5">College Plan</h1>
                        <h2 class="subtitle is-6"><i>$25/mo</i></h2>
                        <ul>
                            <li>Unlimited Coaches</li>
                            <li>Unlimited Players</li>
                            <li>Unlimited Stringers</li>
                        </ul>
                    </div>
                    @if(Auth::check())
                        @if(Auth::user()->role == 'COACH')
                            <a class="button is-primary" href="/profile" rel="nofollow">Upgrade Now!</a>
                        @endif
                    @elseif(Auth::guest())
                        <a class="button is-primary" href="/register/3" rel="nofollow">Join Now!</a>
                    @endif
                </div>
            </center>
        </div>
    </div>
    <hr>
    <center><h1 class="title is-4">Still Have Questions?</h1></center>
    <br>
    <center><h2 class="subtitle is-5"><i>Contact us now and watch our twitter for updates!</i></h2></center>
    <br>
    <div class="columns">
        <div class="column">
            <h1 class="title is-4"><i>Contact Us</i></h1>
            <div class="box">
                {!! Form::open(['HomeController@submitSupportTicket']) !!}
                    <div class="field">
                        <label class="label">Name *</label>
                        <div class="control">
                            {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email *</label>
                        <div class="control">
                            {!! Form::email('email', null, ['placeholder' => 'Email', 'class' => 'input']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Inquiry Reason *</label>
                        <div class="select">
                            {!! Form::select('reason', [
                                1 => 'General Questions',
                                2 => 'Billing',
                                3 => 'Plans',
                                4 => 'Bug or Another Online Issue',
                                5 => 'Other'
                            ], null, ['placeholder' => 'Select One', 'class' => 'select']) !!}
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Message *</label>
                        <div class="control">
                            {!! Form::textarea('msg', null, ['class' => 'textarea']) !!}
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6Lf2uHUUAAAAAO8HMK2l0firYKpFY7zmJwUHPqQr"></div>
                    <button class="button is-primary" type="submit">Send</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="column">
            <a class="twitter-timeline" data-lang="en" data-height="675" data-theme="light" href="https://twitter.com/StringerTeam?ref_src=twsrc%5Etfw">Tweets by @StringerTeam</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
    </div>
</div>
@endsection
