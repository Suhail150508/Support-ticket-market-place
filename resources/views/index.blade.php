
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SupportPro - Advanced Ticket System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --accent: #f59e0b;
            --dark: #1e293b;
            --darker: #0f172a;
            --light: #f8fafc;
            --gray: #64748b;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: var(--dark);
        }
        
        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 30px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .nav-link {
            font-weight: 500;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary) !important;
        }
        
        /* Hero Section */
        .hero-section {
            padding: 160px 0 100px;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
            z-index: -2;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 2px, transparent 0),
                              radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 1px, transparent 0);
            background-size: 50px 50px, 30px 30px;
            z-index: -1;
        }
        
        .hero-title {
            font-size: 3.8rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease 0.3s forwards;
        }
        
        /* Animated Icons Container */
        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        
        .floating-icon {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            animation: floatComplex 6s ease-in-out infinite;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        /* Individual Icon Animations */
        .icon-1 {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
            background: linear-gradient(45deg, rgba(99, 102, 241, 0.3), rgba(79, 70, 229, 0.3));
        }
        
        .icon-2 {
            width: 100px;
            height: 100px;
            top: 15%;
            right: 15%;
            animation-delay: 1s;
            background: linear-gradient(45deg, rgba(16, 185, 129, 0.3), rgba(5, 150, 105, 0.3));
        }
        
        .icon-3 {
            width: 70px;
            height: 70px;
            bottom: 25%;
            left: 15%;
            animation-delay: 2s;
            background: linear-gradient(45deg, rgba(245, 158, 11, 0.3), rgba(217, 119, 6, 0.3));
        }
        
        .icon-4 {
            width: 90px;
            height: 90px;
            bottom: 30%;
            right: 10%;
            animation-delay: 3s;
            background: linear-gradient(45deg, rgba(236, 72, 153, 0.3), rgba(219, 39, 119, 0.3));
        }
        
        .icon-5 {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 5%;
            animation-delay: 4s;
            background: linear-gradient(45deg, rgba(139, 92, 246, 0.3), rgba(124, 58, 237, 0.3));
        }
        
        .icon-6 {
            width: 85px;
            height: 85px;
            top: 45%;
            right: 5%;
            animation-delay: 5s;
            background: linear-gradient(45deg, rgba(14, 165, 233, 0.3), rgba(2, 132, 199, 0.3));
        }
        
        .icon-7 {
            width: 75px;
            height: 75px;
            bottom: 15%;
            left: 25%;
            animation-delay: 1.5s;
            background: linear-gradient(45deg, rgba(34, 197, 94, 0.3), rgba(21, 128, 61, 0.3));
        }
        
        .icon-8 {
            width: 95px;
            height: 95px;
            top: 65%;
            right: 25%;
            animation-delay: 3.5s;
            background: linear-gradient(45deg, rgba(249, 115, 22, 0.3), rgba(234, 88, 12, 0.3));
        }
        
        /* Main Feature Card */
        .main-feature-card {
            background: rgba(26, 202, 70, 0.603);
            border-radius: 25px;
            padding: 50px 40px;
            text-align: center;
            margin: 0 auto;
            max-width: 400px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 10;
            animation: pulseGlow 4s ease-in-out infinite;
        }
        
        .main-feature-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 3rem;
            color: white;
            animation: bounceRotate 3s ease-in-out infinite;
            box-shadow: 0 15px 35px rgba(99, 102, 241, 0.4);
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(99, 102, 241, 0.4);
        }
        
        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary-custom:hover::before {
            left: 100%;
        }
        
        .btn-outline-light-custom {
            border: 2px solid rgba(255,255,255,0.8);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            background: transparent;
            position: relative;
            overflow: hidden;
        }
        
        .btn-outline-light-custom:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: var(--light);
        }
        
        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, var(--dark), var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 4rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 50px 30px;
            text-align: center;
            margin: 15px;
            transition: all 0.4s ease;
            border: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            width: 90px;
            height: 90px;
            background: linear-gradient(45deg, var(--primary), var(--primary-dark));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.2rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        /* Stats Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--darker) 0%, #1e293b 100%);
            color: white;
            position: relative;
        }
        
        .stat-item {
            text-align: center;
            padding: 20px;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }
        
        /* Testimonials */
        .testimonials-section {
            padding: 100px 0;
            background: var(--light);
        }
        
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            color: var(--gray);
            line-height: 1.6;
        }
        
        .client-info {
            display: flex;
            align-items: center;
        }
        
        .client-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 15px;
        }
        
        /* Footer */
        .footer {
            background: var(--darker);
            color: white;
            padding: 80px 0 0;
        }
        
        .footer h5 {
            color: white;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 1rem;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 30px 0;
            margin-top: 50px;
            text-align: center;
            color: #94a3b8;
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 1rem;
        }
        
        .newsletter-input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 5px 0 0 5px;
            background: rgba(255,255,255,0.1);
            color: white;
            outline: none;
        }
        
        .newsletter-input::placeholder {
            color: #94a3b8;
        }
        
        .newsletter-input:focus {
            background: rgba(255,255,255,0.15);
        }
        
        .newsletter-btn {
            background: var(--primary);
            border: none;
            padding: 0 20px;
            border-radius: 0 5px 5px 0;
            color: white;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .newsletter-btn:hover {
            background: var(--primary-dark);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes floatComplex {
            0%, 100% {
                transform: translateY(0px) translateX(0px) rotate(0deg) scale(1);
            }
            25% {
                transform: translateY(-20px) translateX(10px) rotate(5deg) scale(1.05);
            }
            50% {
                transform: translateY(-10px) translateX(-5px) rotate(-3deg) scale(1.1);
            }
            75% {
                transform: translateY(-15px) translateX(5px) rotate(2deg) scale(1.05);
            }
        }
        
        @keyframes bounceRotate {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-10px) rotate(5deg);
            }
            50% {
                transform: translateY(-5px) rotate(-5deg);
            }
            75% {
                transform: translateY(-8px) rotate(3deg);
            }
        }
        
        @keyframes pulseGlow {
            0%, 100% {
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            }
            50% {
                box-shadow: 0 25px 80px rgba(99, 102, 241, 0.3);
            }
        }
        
        @keyframes spinSlow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }
        
        .animate-on-scroll.animated {
            opacity: 1;
            transform: translateY(0);
        }

        /* Icon-specific animations */
        .fa-comments { animation: shake 2s ease-in-out infinite; }
        .fa-robot { animation: spinSlow 8s linear infinite; }
        .fa-bolt { animation: bounceRotate 2s ease-in-out infinite; }
        .fa-chart-line { animation: floatComplex 5s ease-in-out infinite; }
        .fa-headset { animation: shake 3s ease-in-out infinite; }
        .fa-tachometer-alt { animation: bounceRotate 2.5s ease-in-out infinite; }
        .fa-cloud { animation: floatComplex 6s ease-in-out infinite; }
        .fa-shield-alt { animation: spinSlow 10s linear infinite; }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .main-feature-card {
                margin-top: 2rem;
                padding: 30px 20px;
            }
            
            .floating-icon {
                width: 50px !important;
                height: 50px !important;
                font-size: 1.5rem !important;
            }
            
            .feature-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ticket-alt me-2"></i>SupportPro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-dark" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#contact">Contact</a></li>
                    @auth
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('tickets.index') }}">
                                Dashboard <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">
                                Sign In
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('register') }}">
                                Get Started Free
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-pattern"></div>
        
        <!-- Animated Floating Icons -->
        <div class="floating-icons">
            <div class="floating-icon icon-1">
                <i class="fas fa-comments"></i>
            </div>
            <div class="floating-icon icon-2">
                <i class="fas fa-robot"></i>
            </div>
            <div class="floating-icon icon-3">
                <i class="fas fa-bolt"></i>
            </div>
            <div class="floating-icon icon-4">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="floating-icon icon-5">
                <i class="fas fa-headset"></i>
            </div>
            <div class="floating-icon icon-6">
                <i class="fas fa-tachometer-alt"></i>
            </div>
 
            <div class="floating-icon icon-8">
                <i class="fas fa-shield-alt"></i>
            </div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Revolutionize Your Customer Support Experience</h1>
                    <p class="hero-subtitle">AI-powered ticket management system that streamlines support, boosts productivity, and delights your customers with lightning-fast responses.</p>
                    <div class="cta-buttons">
                        @auth
                            <a href="{{ route('tickets.index') }}" class="btn btn-primary-custom me-3">
                                Go to Dashboard <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary-custom me-3">
                                Start Free Trial <i class="fas fa-rocket ms-2"></i>
                            </a>
                            <a href="#features" class="btn btn-outline-light-custom">
                                <i class="fas fa-play-circle me-2"></i>Watch Demo
                            </a>
                        @endauth
                    </div>
                    <div class="mt-4">
                        <p class="text-white-50"><i class="fas fa-check-circle text-success me-2"></i>No credit card required</p>
                        <p class="text-white-50"><i class="fas fa-check-circle text-success me-2"></i>14-day free trial</p>
                        <p class="text-white-50"><i class="fas fa-check-circle text-success me-2"></i>Setup in 5 minutes</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="main-feature-card">
                        <div class="main-feature-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h4>Smart Ticket Management</h4>
                        <p>AI-powered routing and automated responses for efficient support</p>
                        <div class="mt-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <i class="fas fa-clock text-primary mb-2"></i>
                                    <small>24/7 Support</small>
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-brain text-success mb-2"></i>
                                    <small>AI Powered</small>
                                </div>
                                <div class="col-4">
                                    <i class="fas fa-chart-bar text-warning mb-2"></i>
                                    <small>Live Analytics</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title">Everything You Need for Superior Support</h2>
                    <p class="section-subtitle">Powerful features that transform your customer support operations</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Lightning Fast</h4>
                        <p>Instant ticket creation and real-time collaboration with live updates</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Smart Automation</h4>
                        <p>AI-powered routing, response suggestions, and automated workflows</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>Advanced Analytics</h4>
                        <p>Comprehensive reports and performance insights with real-time data</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Team Collaboration</h4>
                        <p>Seamless teamwork with internal notes, assignments, and shared inbox</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h4>Mobile Ready</h4>
                        <p>Full functionality on all devices with native mobile app experience</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card animate-on-scroll">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Enterprise Security</h4>
                        <p>Bank-level security with end-to-end encryption and compliance</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-count="25000">0</div>
                        <p>Tickets Processed</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-count="99">0</div>
                        <p>Customer Satisfaction</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-count="500">0</div>
                        <p>Businesses Trust Us</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item animate-on-scroll">
                        <div class="stat-number" data-count="24">0</div>
                        <p>Avg. Response Time (hrs)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="section-title">Trusted by Industry Leaders</h2>
                    <p class="section-subtitle">See what our customers say about their experience</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-text">
                            "SupportPro transformed our customer service operations. Response times improved by 65% and customer satisfaction skyrocketed. The AI features are game-changing!"
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">SJ</div>
                            <div>
                                <h6>Sarah Johnson</h6>
                                <p class="text-muted">CTO, TechInnovate</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-text">
                            "The AI features are incredible! It suggests responses that are 90% accurate, saving our team hours every day. Implementation was smooth and support is excellent."
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">MR</div>
                            <div>
                                <h6>Mike Rodriguez</h6>
                                <p class="text-muted">Support Manager, CloudScale</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card animate-on-scroll">
                        <div class="testimonial-text">
                            "Implementation was seamless and the results were immediate. Our ticket resolution time dropped from 48 to 12 hours. The analytics dashboard is incredibly insightful."
                        </div>
                        <div class="client-info">
                            <div class="client-avatar">EP</div>
                            <div>
                                <h6>Emily Parker</h6>
                                <p class="text-muted">Operations Director, StartupGrid</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-ticket-alt me-2"></i>SupportPro</h5>
                    <p class="text-light mb-4">Revolutionizing customer support with AI-powered ticket management solutions for businesses of all sizes. Faster responses, happier customers.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Product</h5>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#">Integrations</a></li>
                        <li><a href="#">Updates</a></li>
                        <li><a href="#">Roadmap</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Tutorials</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Company</h5>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#">Partners</a></li>
                        <li><a href="#">Press Kit</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Legal</h5>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">GDPR</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <h5>Stay Updated</h5>
                    <p class="text-light mb-3">Subscribe to our newsletter for product updates and news.</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                        <button type="submit" class="newsletter-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contact Info</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Business Ave, Suite 100</li>
                        <li><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-envelope me-2"></i> hello@supportpro.com</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6 text-md-start text-center mb-2">
                        <p>&copy; 2024 SupportPro. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <p>Made with <i class="fas fa-heart text-danger"></i> for the support community</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Keep all your existing head, style, and navbar sections intact -->

<!-- Stats Section Updated JS -->
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Scroll animations
    function animateOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('animated');
            }
        });
    }

    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('load', animateOnScroll);

    // Number counting animation
    function animateNumbers() {
        const counters = document.querySelectorAll('.stat-number');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-count');
            let count = 0;
            const increment = target / 200; // 200 steps for smooth animation

            function updateCounter() {
                count += increment;
                if (count < target) {
                    counter.innerText = Math.ceil(count);
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target;
                }
            }
            updateCounter();
        });
    }

    window.addEventListener('load', animateNumbers);
</script>

</body>
</html>