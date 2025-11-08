<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('tickets.index') }}">
            <i class="fas fa-ticket-alt me-2"></i>Support System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border: 1px solid rgba(255,255,255,0.3);">
            <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets.index') }}">
                            <i class="fas fa-list me-1"></i>My Tickets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tickets.create') }}">
                            <i class="fas fa-plus-circle me-1"></i>New Ticket
                        </a>
                    </li>
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-user-shield me-1"></i>Admin Panel
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href=""><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
