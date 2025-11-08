<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - {{ config('app.name', 'Support Ticket System') }}</title>
    
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

        .forgot-container {
            max-width: 450px;
            width: 100%;
        }

        .forgot-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        .forgot-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 2.5rem;
            text-align: center;
        }

        .forgot-header i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .forgot-header h2 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .forgot-header p {
            opacity: 0.9;
            margin: 0;
            font-size: 0.9rem;
        }

        .forgot-body {
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

        .btn-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.875rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            color: #fff;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: #fff;
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

        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-box i {
            color: #0284c7;
            margin-right: 0.5rem;
        }

        .info-box p {
            margin: 0;
            color: #0369a1;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-card">
            <div class="forgot-header">
                <i class="fas fa-unlock-alt"></i>
                <h2>Forgot Password?</h2>
                <p>No worries, we'll send you reset instructions</p>
            </div>
            <div class="forgot-body">
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

                <div class="info-box">
                    <p>
                        <i class="fas fa-info-circle"></i>
                        Enter your email address and we'll send you a link to reset your password.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="Enter your email">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-send">
                        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-link">
                            <i class="fas fa-arrow-left me-1"></i>Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
