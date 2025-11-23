<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', __('Support Ticket System')) }} - {{__('Admin Panel')}}</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    
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
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <i class="fas fa-ticket-alt"></i>{{__('Admin Panel')}}
            </a>
        </div>
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>{{__('Dashboard')}}</span>
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                <span>{{__('All Tickets')}}</span>
            </a>
            <a href="{{ route('admin.tickets.create') }}" class="nav-link {{ request()->routeIs('admin.tickets.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle"></i>
                <span>{{__('Create Ticket')}}</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>{{__('Users')}}</span>
            </a>
            <a href="{{ route('admin.homepage.index') }}" class="nav-link {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>{{__('Home Page')}}</span>
            </a>
            <a href="{{ route('admin.subscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i>
                <span>{{__('Subscriptions')}}</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i>
                <span>{{__('Categories')}}</span>
            </a>
            <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                <span>{{__('Departments')}}</span>
            </a>
            <a href="{{ route('admin.chat.index') }}" class="nav-link {{ request()->routeIs('admin.chat.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span>{{__('Live Chat')}}</span>
            </a>
            <a href="{{ route('tickets.index') }}" class="nav-link">
                <i class="fas fa-arrow-left"></i>
                <span>{{__('Back to Site')}}</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <small class="text-muted opacity-75">{{ auth()->user()->email }}</small>
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
                <h1 class="page-title mb-0">@yield('page-title', __('Admin Dashboard'))</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="adminNotifBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell me-2"></i><span id="admin-notif-count" class="badge bg-danger">0</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminNotifBtn" style="min-width: 360px;" id="admin-notif-menu">
                        <li class="dropdown-item text-muted">{{__('No messages')}}</li>
                    </ul>
                </div>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>{{__('View Site')}}
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
        (function(){
            let since = null;
            let events = [];
            function dedupeAdd(ev) {
                const key = ev.type + ':' + ev.ticket_id + ':' + ev.created_at;
                if (!events.find(e => (e.type+':'+e.ticket_id+':'+e.created_at) === key)) {
                    events.unshift(ev);
                    events = events.slice(0, 20);
                }
            }
            function renderList() {
                const menu = document.getElementById('admin-notif-menu');
                const countEl = document.getElementById('admin-notif-count');
                if (!menu || !countEl) return;
                countEl.textContent = events.length;
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
                    a.href = '{{ url('admin/tickets') }}/' + ev.ticket_id;
                    a.dataset.index = idx;
                    const content = document.createElement('div');
                    content.innerHTML = `<div class="fw-semibold">{{__('New ticket')}}</div><div class="small text-muted">${ev.subject || ''}</div>`;
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
                            await fetch('{{ route('notifications.read.admin') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ ticket_id: ev.ticket_id })
                            });
                        } catch (e) {}
                        events.splice(idx, 1);
                        renderList();
                    }
                });
            }
            async function poll() {
                try {
                    const url = new URL('{{ route('notifications.admin') }}', window.location.origin);
                    if (since) url.searchParams.set('since', since);
                    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const data = await res.json();
                    since = data.now;
                    (data.events||[]).forEach(ev => dedupeAdd(ev));
                    renderList();
                } catch(e) {}
            }
            setInterval(poll, 5000);
            poll();
        })();
        // Hide caret on dropdown button
        const adminBtn = document.getElementById('adminNotifBtn');
        if (adminBtn) { const style = document.createElement('style'); style.innerHTML = '#adminNotifBtn::after{display:none;}'; document.head.appendChild(style); }
    </script>
    
    @stack('scripts')
</body>
</html>