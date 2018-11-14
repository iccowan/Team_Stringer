<br>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a href="/" style="max-height:1.75rem">
                <img src="{{ url('/images/team-stringer-logo.png') }}" width="165">
              </a>

              <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
              </a>
            </div>
        &nbsp;&nbsp;
        <div class="navbar-start">
            <a class="navbar-item" href="/" rel="nofollow">
                Home
            </a>
            @if(Auth::guest())
            @else
                @if(Auth::user()->role == "STAFF")
                    <a class="navbar-item" href="/staff/coaches-account-manage" rel="nofollow">
                        Manage Coach Accounts
                    </a>
                    @if(Auth::id() == 3)
                        <a class="navbar-item" href="/staff/staff-manage" rel="nofollow">
                            Manage Staff
                        </a>
                    @endif
                @elseif(Auth::user()->role == "COACH")
                    <a class="navbar-item" href="/coach/roster-manage" rel="nofollow">
                        Manage Roster
                    </a>
                    <a class="navbar-item" href="/coach/racquets-view" rel="nofollow">
                        Team Stringing Requests
                    </a>
                @elseif(Auth::user()->role == "STRING")
                    <a class="navbar-item" href="/player/my-racquets" rel="nofollow">
                        My Racquets
                    </a>
                    <a class="navbar-item" href="/player/my-string-requests" rel="nofollow">
                        My Stringing Requests
                    </a>
                    <a class="navbar-item" href="/stringer/team-string-requests" rel="nofollow">
                        Team Stringing Requests
                    </a>
                @else
                    <a class="navbar-item" href="/player/my-racquets" rel="nofollow">
                        My Racquets
                    </a>
                    <a class="navbar-item" href="/player/my-string-requests" rel="nofollow">
                        My Stringing Requests
                    </a>
                @endif
            @endif
            <a class="navbar-item" href="/contact" rel="nofollow">
                Contact Us
            </a>
        </div>
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                    @if(Auth::guest())
                        <p class="control">
                            <a class="button" href="/login" rel="nofollow">
                                Login
                            </a>
                        </p>
                    @else
                        <a class="navbar-item" href="/profile" rel="nofollow">
                            {{ Auth::user()->name }}&nbsp;-&nbsp;<i>{{ Auth::user()->team_name }}</i>
                        </a>
                        <p class="control">
                            <a class="button" href="/logout" rel="nofollow">
                                Logout
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
<hr>
