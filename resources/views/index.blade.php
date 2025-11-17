@extends('layouts.frontend')
@section('page-title', __('Welcome to Support Ticket System'))

@stack('head')
@stack('styles')

@section('content')
 <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-bg"></div>
        <div class="hero-pattern"></div>

        <!-- Floating Icons (Static or Dynamic) -->
        <div class="floating-icons">
            @php
                $icons = ['comments','robot','bolt','chart-line','headset','tachometer-alt'];
            @endphp
            @foreach($icons as $index => $icon)
                <div class="floating-icon icon-{{ $index+1 }}">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>
            @endforeach
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">{{ $hero['title'] ?? 'Revolutionize Your Customer Support Experience' }}</h1>
                    <p class="hero-subtitle">{{ $hero['subtitle'] ?? 'AI-powered ticket management system that streamlines support, boosts productivity, and delights your customers with lightning-fast responses.' }}</p>
                    <div class="cta-buttons">
                        <a href="{{ $hero['primary_button']['url'] ?? '#' }}" class="btn btn-primary-custom me-3">
                            {{ $hero['primary_button']['text'] ?? 'Primary Button' }}
                        </a>
                        <a href="{{ $hero['secondary_button']['url'] ?? '#' }}" class="btn btn-outline-light-custom">
                            {{ $hero['secondary_button']['text'] ?? 'Secondary Button' }}
                        </a>
                    </div>
                    <div class="mt-4">
                        @if(!empty($hero['features']) && is_array($hero['features']))
                            @foreach($hero['features'] as $feature)
                                <p class="text-white-50"><i class="fas fa-check-circle text-success me-2"></i>{{ $feature }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 text-center">
                    <div class="main-feature-card">
                        <div class="main-feature-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h4>{{ $hero['cart_title'] ?? 'Smart Ticket Management' }}</h4>
                        <p>{{ $hero['cart_subtitle'] ?? 'AI-powered routing and automated responses for efficient support' }}</p>
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
                    <h2 class="section-title">
                        {{ $features['title'] ?? 'Everything You Need for Superior Support' }}
                    </h2>
                    <p class="section-subtitle">
                        {{ $features['subtitle'] ?? 'Powerful features that transform your customer support operations' }}
                    </p>
                </div>
            </div>
            <div class="row">
                @if(isset($features['items']) && is_array($features['items']) && count($features['items']) > 0)
                    @foreach($features['items'] as $feature)
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card animate-on-scroll">
                                <div class="feature-icon">
                                    <i class="{{ $feature['icon'] ?? 'fas fa-star' }}"></i>
                                </div>
                                <h4>{{ $feature['title'] ?? 'Feature Title' }}</h4>
                                <p>{{ $feature['description'] ?? 'Feature description goes here.' }}</p>
                            </div>
                        </div>
                    @endforeach
               @else
                    {{-- Updated Default Features According to JSON --}}

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <h4>{{ __('Account and Profile') }}</h4>
                            <p>{{ __('Easily set up, update, and customize your account details to enjoy a personalized support experience.') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h4>{{ __('Ticket Management System') }}</h4>
                            <p>{{ __('Create, track, and manage support tickets efficiently with real-time updates and smooth collaboration.') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h4>{{ __('Message & Live Chatting') }}</h4>
                            <p>{{ __('Communicate instantly with support agents through real-time messaging and seamless live chat.') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <h4>{{ __('Lightning Fast') }}</h4>
                            <p>{{ __('Instant ticket creation and real-time collaboration with live updates') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-brain"></i>
                            </div>
                            <h4>{{ __('Smart Automation') }}</h4>
                            <p>{{ __('AI-powered routing, response suggestions, and automated workflows') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card animate-on-scroll">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4>{{ __('Enterprise Security') }}</h4>
                            <p>{{ __('Bank-level security with end-to-end encryption and compliance') }}</p>
                        </div>
                    </div>

                @endif

            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                @if(isset($stats['items']) && is_array($stats['items']) && count($stats['items']) > 0)
                    @foreach($stats['items'] as $stat)
                        <div class="col-md-3 col-6">
                            <div class="stat-item animate-on-scroll">
                                <div class="stat-number" data-count="{{ $stat['number'] ?? 0 }}">0</div>
                                <p>{{ $stat['label'] ?? 'Stat' }}</p>
                            </div>
                        </div>
                    @endforeach
               @else
                    {{-- Default static stats --}}
                    <div class="col-md-3 col-6">
                        <div class="stat-item animate-on-scroll">
                            <div class="stat-number" data-count="25000">0</div>
                            <p>{{ __('Tickets Processed') }}</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="stat-item animate-on-scroll">
                            <div class="stat-number" data-count="99">0</div>
                            <p>{{ __('Customer Satisfaction') }}</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="stat-item animate-on-scroll">
                            <div class="stat-number" data-count="500">0</div>
                            <p>{{ __('Businesses Trust Us') }}</p>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="stat-item animate-on-scroll">
                            <div class="stat-number" data-count="24">0</div>
                            <p>{{ __('Avg. Response Time (hrs)') }}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing-section" style="padding: 100px 0; background: var(--light);">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="section-title">{{__('Choose Your Subscription Plan')}}</h2>
                    <p class="section-subtitle">{{__('Get access to live chat support with our flexible subscription plans')}}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                @php
                    try {
                        $plans = \App\Models\SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->take(3)->get();
                    } catch (\Exception $e) {
                        $plans = collect([]);
                    }
                @endphp
                @forelse($plans as $plan)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="home-pricing-card {{ $plan->is_popular ? 'popular-home-plan' : '' }}">
                        @if($plan->is_popular)
                        <div class="popular-home-badge">
                            <i class="fas fa-star me-1"></i>{{__('Most Popular')}}
                        </div>
                        @endif
                        <div class="home-pricing-header">
                            <div class="home-pricing-icon">
                                <i class="fas fa-{{ $plan->is_popular ? 'crown' : 'gem' }}"></i>
                            </div>
                            <h4 class="home-pricing-name">{{ $plan->name }}</h4>
                        </div>
                        <div class="home-pricing-price">
                            <span class="home-currency">{{ $plan->currency }}</span>
                            <span class="home-amount">{{ number_format($plan->price, 0) }}</span>
                            <span class="home-period">/{{ ucfirst($plan->billing_cycle) }}</span>
                        </div>
                        <p class="home-pricing-desc">{{ Str::limit($plan->description, 80) }}</p>
                        <div class="home-pricing-features">
                            <div class="home-feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ $plan->duration_days }} {{__('Days Access')}}</span>
                            </div>
                            @if($plan->features)
                                @foreach(array_slice($plan->features, 0, 2) as $feature)
                                <div class="home-feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $feature }}</span>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @auth
                            <a href="{{ route('subscriptions.purchase', $plan->id) }}" class="home-pricing-btn {{ $plan->is_popular ? 'btn-home-popular' : '' }}">
                                <span>{{__('Purchase Now')}}</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="home-pricing-btn {{ $plan->is_popular ? 'btn-home-popular' : '' }}">
                                <span>{{__('Sign Up')}}</span>
                                <i class="fas fa-user-plus"></i>
                            </a>
                        @endauth
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">{{__('Subscription plans coming soon!')}}</p>
                    @auth
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-credit-card me-2"></i>{{__('View All Plans')}}
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-user-plus me-2"></i>{{__('Sign Up to View Plans')}}
                    </a>
                    @endauth
                </div>
                @endforelse
            </div>
            @if($plans->count() > 0)
            <div class="row mt-4">
                <div class="col-12 text-center">
                    @auth
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-arrow-right me-2"></i>{{__('View All Subscription Plans')}}
                    </a>
                    @else
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus me-2"></i>{{__('Sign Up to View All Plans')}}
                    </a>
                    @endauth
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section" style="padding: 100px 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="section-title" style="color: white; margin-bottom: 1rem;">
                        {{ $contact['title'] ?? 'Get In Touch' }}
                    </h2>
                    <p class="section-subtitle" style="color: rgba(255,255,255,0.9);">
                        {{ $contact['subtitle'] ?? "Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible." }}
                    </p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-card" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px; padding: 50px; border: 1px solid rgba(255,255,255,0.2);">
                        <form class="contact-form">
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-lg" placeholder="{{ $contact['name_placeholder'] ?? 'Your Name' }}" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 10px;" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control form-control-lg" placeholder="{{ $contact['email_placeholder'] ?? 'Your Email' }}" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 10px;" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control form-control-lg" placeholder="{{ $contact['subject_placeholder'] ?? 'Subject' }}" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 10px;" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control form-control-lg" rows="5" placeholder="{{ $contact['message_placeholder'] ?? 'Your Message' }}" style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white; border-radius: 10px;" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary-custom btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>{{ $contact['button_text'] ?? 'Send Message' }}
                                </button>
                            </div>
                        </form>
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
                    <h2 class="section-title">{{ $testimonials['title'] ?? __('Trusted by Industry Leaders') }}</h2>
                    <p class="section-subtitle">{{ $testimonials['subtitle'] ?? __('See what our customers say about their experience') }}</p>
                </div>
            </div>
            <div class="row">
                @if(isset($testimonials['items']) && is_array($testimonials['items']))
                    @foreach($testimonials['items'] as $testimonial)
                        <div class="col-lg-4">
                            <div class="testimonial-card animate-on-scroll">
                                <div class="testimonial-text">
                                    "{{ $testimonial['text'] ?? __('Testimonial text') }}"
                                </div>
                                <div class="client-info">
                                    <div class="client-avatar">{{ $testimonial['avatar'] ?? substr($testimonial['author'] ?? 'U', 0, 2) }}</div>
                                    <div>
                                        <h6>{{ $testimonial['author'] ?? __('Client') }}</h6>
                                        <p class="text-muted">{{ $testimonial['position'] ?? __('Position') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-4">
                        <div class="testimonial-card animate-on-scroll">
                            <div class="testimonial-text">
                                "{{__('SupportSystem transformed our customer service operations. Response times improved by 65% and customer satisfaction skyrocketed. The features are game-changing!')}}"
                            </div>
                            <div class="client-info">
                                <div class="client-avatar">{{__('SJ')}}</div>
                                <div>
                                    <h6>{{__('Sarah Johnson')}}</h6>
                                    <p class="text-muted">{{__('CTO, TechInnovate')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-card animate-on-scroll">
                            <div class="testimonial-text">
                                "{{__('The features are incredible! It suggests responses that are 90% accurate, saving our team hours every day. Implementation was smooth and support is excellent.')}}"
                            </div>
                            <div class="client-info">
                                <div class="client-avatar">{{__('MR')}}</div>
                                <div>
                                    <h6>{{__('Mike Rodriguez')}}</h6>
                                    <p class="text-muted">{{__('Support Manager, CloudScale')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testimonial-card animate-on-scroll">
                            <div class="testimonial-text">
                                "{{__('Implementation was seamless and the results were immediate. Our ticket resolution time dropped from 48 to 12 hours. The analytics dashboard is incredibly insightful.')}}"
                            </div>
                            <div class="client-info">
                                <div class="client-avatar">{{__('EP')}}</div>
                                <div>
                                    <h6>{{__('Emily Parker')}}</h6>
                                    <p class="text-muted">{{__('Operations Director, StartupGrid')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')

    @endpush

@endsection