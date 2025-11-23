<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', __('Support Ticket System')) }} - {{__('Dashboard')}}</title>
    <link rel="stylesheet" href="{{ asset('assets/user/css/style.css') }}">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @stack('head')
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('user.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-ticket-alt"></i>{{__('SupportSystem')}}
            </a>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>{{__('Dashboard')}}</span>
            </a>
            <a href="{{ route('tickets.index') }}" class="nav-link {{ request()->routeIs('tickets.index') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                <span>{{__('My Tickets')}}</span>
            </a>
            <a href="{{ route('tickets.create') }}" class="nav-link {{ request()->routeIs('tickets.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span>{{__('Create Ticket')}}</span>
            </a>
            <a href="{{ route('subscriptions.index') }}" class="nav-link {{ request()->routeIs('subscriptions.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>{{__('Subscriptions')}}</span>
            </a>
            <a href="{{ route('subscription-history.index') }}" class="nav-link {{ request()->routeIs('subscription-history.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>{{__('Subscription History')}}</span>
            </a>
            <a href="{{ route('chat.index') }}" class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span>{{__('Live Chat')}}</span>
            </a>
            <a href="{{ route('profile.index') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>{{__('My Profile')}}</span>
            </a>
            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-user-shield"></i>
                    <span>{{__('Admin Panel')}}</span>
                </a>
            @endif
            <a href="{{ route('home') }}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>{{__('Home')}}</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    @php
                        $user = auth()->user();
                        $hasImage = $user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists('profiles/' . $user->image);
                    @endphp
                    @if($hasImage)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url('profiles/' . $user->image) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ $user->name }}</div>
                    <small class="text-muted opacity-75">{{ $user->email }}</small>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>{{__('Logout')}}
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle me-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title mb-0">@yield('page-title', __('Dashboard'))</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="userNotifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell me-2"></i><span id="user-notif-count" class="badge bg-danger">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userNotifDropdown" style="min-width: 360px;" id="user-notif-menu">
                        <li class="dropdown-item text-muted">{{__('No messages')}}
                        </li>
                    </ul>
                </div>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>{{__('Home')}}
                </a>
            </div>
        </div>

        <!-- Content Area -->
    <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
        // Poll notifications
        (function(){
            let since = null;
            let events = [];
            function renderUserNotifs() {
                const count = document.getElementById('user-notif-count');
                const menu = document.getElementById('user-notif-menu');
                if (!count || !menu) return;
                count.textContent = events.length;
                menu.innerHTML = '';
                if (!events.length) {
                    const li = document.createElement('li');
                    li.className = 'dropdown-item text-muted';
                    li.textContent = '{{__('No messages')}}';
                    menu.appendChild(li);
                    return;
                }
                events.forEach((ev, idx) => {
                    const li = document.createElement('li');
                    li.className = 'dropdown-item';
                    const a = document.createElement('a');
                    a.className = 'd-flex justify-content-between align-items-center text-decoration-none';
                    a.href = ev.url || '#';
                    a.dataset.index = idx;
                    const content = document.createElement('div');
                    content.innerHTML = `<div class="fw-semibold">${ev.title}</div><div class="small text-muted">${ev.subtitle}</div>`;
                    const view = document.createElement('span');
                    view.className = 'badge bg-primary';
                    view.textContent = '{{__('View')}}';
                    a.appendChild(content);
                    a.appendChild(view);
                    li.appendChild(a);
                    menu.appendChild(li);
                });
                menu.addEventListener('click', async function(e){
                    const anchor = e.target.closest('a');
                    if (!anchor) return;
                    const idx = parseInt(anchor.dataset.index, 10);
                    if (!isNaN(idx)) {
                        const ev = events[idx];
                        try {
                            await fetch('{{ route('notifications.read') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ ticket_id: ev.ticket_id })
                            });
                        } catch (e) {}
                        events.splice(idx, 1);
                        renderUserNotifs();
                    }
                });
            }
            async function poll() {
                try {
                    const url = new URL('{{ route('notifications.user') }}', window.location.origin);
                    if (since) url.searchParams.set('since', since);
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const data = await res.json();
                    since = data.now;
                    (data.events||[]).forEach(ev => {
                        const key = 'reply:'+ev.ticket_id+':'+ev.created_at;
                        if (!events.find(x => ('reply:'+x.ticket_id+':'+x.created_at) === key)) {
                            events.unshift({
                                title: '{{__('New reply')}}',
                                subtitle: ev.subject,
                                url: '{{ url('tickets') }}' + '/' + ev.ticket_id,
                                ticket_id: ev.ticket_id,
                                created_at: ev.created_at
                            });
                        }
                    });
                    events = events.slice(0,20);
                    renderUserNotifs();
                } catch(e) {}
            }
            setInterval(poll, 5000);
            poll();
        })();
        // Hide caret on dropdown button
        const userBtn = document.getElementById('userNotifDropdown');
        if (userBtn) { const style = document.createElement('style');
         style.innerHTML = '#userNotifDropdown::after{display:none;}';
         document.head.appendChild(style); }
    </script>
    
    @stack('scripts')
</body>
</html>