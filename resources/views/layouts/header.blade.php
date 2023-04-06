<?php
use App\Category;
$categories = Category::where('is_active', 1)->get();
?>

<div class="container-fluid border-bottom">
    <div class="row align-items-center py-2 px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a href="/" class="text-decoration-none">
                <h1 class="m-0 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border px-3 mr-1">मृ</span>दगंध</h1>
            </a>
        </div>
        <div class="col-lg-5 col-6 text-left">
            <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">मृ</span>दगंध</h1>
                </a>
                <button type="button" class="navbar-toggler mt-4" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="/" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                        <a href="/about-us"
                            class="nav-item nav-link {{ Request::is('about-us') ? 'active' : '' }}">About Us</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Products</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="{{ route('product-index') }}" class="dropdown-item">All Products</a>
                                @foreach ($categories as $category)
                                    <a href="{{ route('product-by-category', ['slug' => $category->slug]) }}"
                                        class="dropdown-item">{{ $category->name }}</a>
                                @endforeach
                            </div>
                        </div>
                        <a href="/contact-us"
                            class="nav-item nav-link {{ Request::is('contact-us') ? 'active' : '' }}">Contact</a>
                    </div>

                </div>
            </nav>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <a href="/login" class="btn border text-primary {{ Auth::check() ? 'd-none' : '' }}">Login</a>
            <a href="" class="btn border text-primary d-none">Register</a>
            <a href="whatsapp://send?text=Hello Mrudhgandh, I would like to connect with you.&amp;phone=+919175904464"
                class="btn border"><i class="fab fa-whatsapp text-primary"></i></a>

            <a href="/cart" class="btn border">
                <i class="fas fa-shopping-cart text-primary"></i>
                <span class="badge cart-count">
                    @if (session()->get('cart'))
                        {{ count(session()->get('cart')) }}
                    @endif
                </span>
            </a>
            @if (Auth::check())
                <a class="dropdown show {{ Auth::check() ? '' : 'd-none' }}">
                    <a href="#" class="btn btn-secondary dropdown-toggle"
                        data-toggle="dropdown">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="/admin/products"
                            class="dropdown-item {{ Auth::user()->role == 1 ? '' : 'd-none' }}">Admin
                            Layout</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </a>
            @endif


        </div>
    </div>
</div>
