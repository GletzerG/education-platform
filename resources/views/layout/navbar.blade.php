<!-- Navbar -->
<nav class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <div class="logo">
                <div class="logo-icon">📚</div>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('dashboard') }}" class="active">Home</a></li>
                <li><a href="*">Daily Mission</a></li>
                <li><a href="{{ route('navbar.classes') }}">Classes</a></li>
                <li><a href="*">Mentor</a></li>
                <li><a href="*">Leaderboard</a></li>
            </ul>

        </div>
        <div class="user-dropdown">
            <div class="user-info" onclick="toggleDropdown()">
                <span class="user-name">User2207</span>
                <div class="user-avatar">👤</div>
                <span class="dropdown-arrow">▼</span>
            </div>
            <div class="dropdown-menu">
                <a href="#login" class="dropdown-item">
                    <span class="dropdown-icon">👤</span>
                    Login
                </a>
                <a href="#signup" class="dropdown-item">
                    <span class="dropdown-icon">📝</span>
                    Sign Up
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
