<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Support Ticket System') }}</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            max-width: 450px;
            width: 100%;
        }

        .login-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 2.5rem;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .login-header h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 0.875rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-group-text {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: #667eea;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.875rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #64748b;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .text-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <i class="fas fa-ticket-alt"></i>
                <h2> {{ __('Welcome Back')}} </h2>
                <p> {{ __('Sign in to your account')}}</p>
            </div>
            <div class="login-body">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label"> {{ __('Email Address')}}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"> {{ __('Password')}}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember"> {{ __('Remember me')}}</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> {{ __('Sign In')}}
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-link"> {{ __('Forgot your password?')}}</a>
                        </div>
                    @endif

                    <div class="register-link">
                        <p class="text-muted mb-0"> {{ __('Do not have an account?') }} <a href="{{ route('register') }}" class="text-link"> {{ __('Sign up here')}}</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
