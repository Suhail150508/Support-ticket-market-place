<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - {{ config('app.name', 'Support Ticket System') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .error-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 700px;
            width: 100%;
        }
        .error-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        .error-header h1 { font-size: 4rem; font-weight: 800; margin: 0; }
        .error-header p { opacity: 0.9; margin: 0.25rem 0 0; }
        .error-body { padding: 2rem; }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.875rem 1.25rem;
            font-weight: 600;
            color: #fff;
        }
        .btn-gradient:hover { color: #fff; box-shadow: 0 10px 25px rgba(102,126,234,0.4); }
        .quick-links .card { border-radius: 14px; }
        .quick-links .icon { font-size: 2rem; }
    </style>
    </head>
<body>
    <div class="error-card">
        <div class="error-header">
            <h1>{{ __('404') }}</h1>
            <p>{{ __("Oops! The page you are looking for doesn't exist.") }}</p>
        </div>

        <div class="error-body">
            <div class="mb-4 d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="fas fa-compass text-primary"></i>
                </div>
                <div>
                    <h5 class="mb-1">{{ __("Let's get you back on track") }}</h5>
                    <p class="text-muted mb-0">{{ __('Here are some helpful links to continue.') }}</p>
                </div>
            </div>

            <div class="row quick-links g-3 mb-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="icon text-primary mb-2"><i class="fas fa-home"></i></div>
                            <h6 class="mb-2">{{ __('Home') }}</h6>
                            <a class="btn btn-sm btn-gradient" href="{{ route('home') }}">{{ __('Go Home') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="icon text-success mb-2"><i class="fas fa-ticket-alt"></i></div>
                            <h6 class="mb-2">{{ __('Tickets') }}</h6>
                            <a class="btn btn-sm btn-gradient" href="{{ route('tickets.index') }}">{{ __('View Tickets') }}</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="icon text-info mb-2"><i class="fas fa-sign-in-alt"></i></div>
                            <h6 class="mb-2">{{ __('Login') }}</h6>
                            <a class="btn btn-sm btn-gradient" href="{{ route('login') }}">{{ __('Sign In') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="javascript:history.back()" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>{{ __('Go Back') }}
                </a>
                <a href="{{ route('home') }}" class="btn btn-gradient">
                    <i class="fas fa-home me-2"></i>{{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>