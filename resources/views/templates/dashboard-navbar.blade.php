<nav role="navigation">
        <ul>
        @if (Route::has('login'))
        <li><a href="{{ URL::to('/') }}"><span class="branding">Alfred 3.0</span></a>
            @auth
                <li><a id="levels" href="{{ URL::to('levels') }}">Levels</a></li>
                <li><a id="users" href="{{ URL::to('users') }}">Employees</a></li>
                <li><a id="skills"  href="{{ URL::to('skills') }}">Skills</a></li>
                <li><a id="positions"  href="{{ URL::to('positions') }}">Positions</a></li>
                <li><a id="quizzes"  href="{{ URL::to('quizzes') }}">Quizzes</a></li>
                <li><a id="training-sessions"  href="{{ URL::to('training_sessions') }}">Training Sessions</a></li>
                <li class="login-button" id="login-button">
                    <a class="logout-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOG OUT</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @else
                <li><a href="#">Calendar</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Policies</a></li>
                <li><a href="#">Engagements</a></li>
                <li><a href="#">HR</a></li>
                <li class="login-button" id="login-button" onclick="hideShowLogin()">
                    LOG IN
                </li>
            @endauth
        @endif
    </ul>
</nav>