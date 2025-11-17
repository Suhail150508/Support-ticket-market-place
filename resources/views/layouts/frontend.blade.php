<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('SupportSystem - Advanced Ticket System')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/user/css/homepage.css') }}">

     @stack('head')
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-ticket-alt me-2"></i>{{__('SupportSystem')}}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-dark" href="#home">{{__('Home')}}</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#features">{{__('Features')}}</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#pricing">{{__('Pricing')}}</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#testimonials">{{__('Testimonials')}}</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#contact">{{__('Contact')}}</a></li>
                    @auth
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('tickets.index') }}">
                                {{__('Dashboard')}} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-dark btn-sm" href="{{ route('login') }}">
                                {{__('Sign In')}}
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary-custom btn-sm" href="{{ route('register') }}">
                                {{__('Get Started Free')}}
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row w-100">
                <div class="col-lg-2 col-md-6 mb-4">
                    <!-- Empty column for spacing -->
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-ticket-alt me-2"></i>{{__('SupportSystem')}}</h5>
                    <p class="text-light mb-4">{{__('Revolutionizing customer support with AI-powered ticket management solutions for businesses of all sizes. Faster responses, happier customers.')}}</p>
                    <div class="social-links">
                        <a href="https://web.facebook.com/sohel.rana.458881" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.linkedin.com/feed/?trk=guest_homepage-basic_google-one-tap-submit" target="_blank"><i class="fab fa-linkedin-in"></i></a>


                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>{{__('Company')}}</h5>
                    <ul class="footer-links">
                        <li><a href="#home">{{__('Home')}}</a></li>
                        <li><a href="#features">{{__('Features')}}</a></li>
                        <li><a href="#contact">{{__('Contact')}}</a></li>
                        <li><a href="#testimonial">{{__('Testimonial')}}</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>{{__('Contact Info')}}</h5>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> {{__('Block Ta, Mirpur 6, Dhaka 1216')}}</li>
                        <li><i class="fas fa-phone me-2"></i> +880 1798562848</li>
                        <li><i class="fas fa-envelope me-2"></i> sohel150508@gmail.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-md-6 text-md-start text-center mb-2">
                        <p>&copy; 2025 {{ __('SupportSystem — All rights reserved.') }}</p>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <p>{{ __('Crafted with') }} <i class="fas fa-heart text-danger"></i> {{ __('to empower your support experience') }}</p>
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

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Contact form handler
        document.querySelector('.contact-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            btn.disabled = true;
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check me-2"></i>Message Sent!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    this.reset();
                }, 2000);
            }, 1500);
        });

        // Newsletter form handler
        document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = this.querySelector('input[type="email"]');
            const btn = this.querySelector('button[type="submit"]');
            const originalHtml = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            // Simulate subscription (replace with actual AJAX call)
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-check"></i>';
                input.value = '';
                setTimeout(() => {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }, 2000);
            }, 1000);
        });
    </script>

    @stack('scripts')

</body>
</html>