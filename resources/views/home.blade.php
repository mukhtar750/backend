@extends('layouts.app')

@section('content')
    @include('layouts.partials.header')

    {{-- Hero Section --}}
    <section class="bg-light py-5 text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Empowering Women Entrepreneurs, BDSPs, and Investors</h1>
            <p class="lead mb-4">Join our ecosystem and unlock growth opportunities tailored for your role.</p>
            <a href="{{ route('register.role') }}" class="btn btn-lg btn-success px-5 py-3 mb-3">Who Are You?</a>
        </div>
    </section>

    {{-- Role-Based Section --}}
    <section class="container py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-12 text-center mb-4">
                <h2 class="fw-bold">Choose Your Role</h2>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('register.investor') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-currency-exchange display-4 text-primary"></i>
                            </div>
                            <h5 class="card-title fw-bold">I am an Investor</h5>
                            <p class="card-text text-muted">Support and empower women-led businesses.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('register.bdsp') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-briefcase display-4 text-warning"></i>
                            </div>
                            <h5 class="card-title fw-bold">I am a BDSP</h5>
                            <p class="card-text text-muted">Offer your expertise to help businesses grow.</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('register.entrepreneur') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-lightbulb display-4 text-success"></i>
                            </div>
                            <h5 class="card-title fw-bold">I am an Entrepreneur</h5>
                            <p class="card-text text-muted">Access resources and funding for your business.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">How It Works</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="mb-2"><span class="badge bg-primary rounded-pill fs-5">1</span></div>
                    <h5 class="fw-bold">Join</h5>
                    <p class="text-muted">Sign up and select your role to get started.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="mb-2"><span class="badge bg-warning text-dark rounded-pill fs-5">2</span></div>
                    <h5 class="fw-bold">Connect</h5>
                    <p class="text-muted">Network with entrepreneurs, BDSPs, and investors.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="mb-2"><span class="badge bg-success rounded-pill fs-5">3</span></div>
                    <h5 class="fw-bold">Grow</h5>
                    <p class="text-muted">Access resources, funding, and support to scale.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section (Optional) --}}
    <section class="container py-5">
        <h2 class="text-center fw-bold mb-4">Success Stories</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>"AWN helped me connect with the right investors and scale my business."</p>
                            <footer class="blockquote-footer mt-2">Aisha, Entrepreneur</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>"Through AWN, I've mentored dozens of women-led startups."</p>
                            <footer class="blockquote-footer mt-2">Ngozi, BDSP</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>"A fantastic platform for impact investing in Nigeria."</p>
                            <footer class="blockquote-footer mt-2">Chinwe, Investor</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partials.footer')
@endsection 