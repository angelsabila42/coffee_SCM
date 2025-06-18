<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

 <style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        margin: 0;
        padding: 0;
        color: #333;
        min-height: 100vh;
    }

    .wrapper {
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(80, 80, 120, 0.10);
        padding: 40px 32px;
    }
    .wrapper label {
        font-weight: 600;
        margin-left: 0px;
        margin-bottom: 8px;
        display: inline-block;
        color: #fff;
        background: linear-gradient(90deg, #8ec5fc 0%, #e0c3fc 100%);
        padding: 6px 18px;
        border-radius: 6px;
        font-size: 1.08rem;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(142,197,252,0.10);
        transition: background  0.2s, color 0.2s;
    }

    .wrapper label:focus,
    .wrapper label:hover {
        background: linear-gradient(90deg, #e0c3fc 0%, #8ec5fc 100%);
        color: #3e2723;}

    h1, h2, h3 {
        color: #3e2723;
        font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 18px;
        text-shadow: 0 2px 8px rgba(142,197,252,0.08);
    }
     .navbar .container > div {
        font-size: 2rem;
        font-weight: bold;
        color: #fff;
        letter-spacing: 2px;
        text-shadow: 0 4px 16px rgba(142,197,252,0.25), 0 1px 0 #3e2723;
        background: linear-gradient(90deg, #8ec5fc 0%, #e0c3fc 100%);
        padding: 12px 32px;
        border-radius: 12px;
        margin: 12px 0;
        box-shadow: 0 2px 12px rgba(142,197,252,0.10);
        border: 2px solid #fff;
        display: inline-block;
    }

    h1 {
        font-size: 2.5rem;
        border-bottom: 2px solid #8ec5fc;
        padding-bottom: 10px;
        margin-bottom: 28px;
    }

    h2 {
        font-size: 2rem;
        border-bottom: 1px solid #e0c3fc;
        padding-bottom: 8px;
        margin-bottom: 22px;
    }

    h3 {
        font-size: 1.4rem;
        margin-bottom: 16px;
    }

    button, input[type="submit"], .btn {
        background: linear-gradient(90deg, #8ec5fc 0%, #e0c3fc 100%);
        color: #3e2723;
        border: none;
        padding: 10px 24px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: background 0.2s, color 0.2s;
        box-shadow: 0 2px 8px rgba(142,197,252,0.08);
        margin-bottom: 5px
    }

    button:hover, input[type="submit"]:hover, .btn:hover {
        background: linear-gradient(90deg, #e0c3fc 0%, #8ec5fc 100%);
        color: #222;
    } 
        .wrapper {
        max-width: 800px;
        margin: 40px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(80, 80, 120, 0.10);
        padding: 56px 48px; /* Increased padding for more space */
    }

    .wrapper input,
    .wrapper select,
    .wrapper textarea {
        padding: 14px 14px;
        border: 2px solid #8ec5fc;
        border-radius: 8px;
        margin-bottom: 22px;
        width: 100%;
        font-size: 1.08rem;
        background: #f7faff;
        color: #3e2723;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(142,197,252,0.08);
    }


    input, select, textarea {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 16px;
        width: 100%;
        box-sizing: border-box;
    }

    label {
        font-weight: 500;
        margin-bottom: 6px;
        display: block;
        color: #3e2723;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 24px;
    }

    th, td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        text-align: left;
    }

    th {
        background: #e0c3fc;
        color: #3e2723;
    }

    .navbar {
        border-radius: 0 0 16px 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        background: linear-gradient(90deg, #8ec5fc 0%, #e0c3fc 100%) !important;
    }

    .navbar .container > div {
        font-size: 1.3rem;
        font-weight: bold;
        color: #3e2723;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px rgba(224,195,252,0.08);
    }

    .nav-link, .dropdown-item {
        color: #3e2723 !important;
        font-weight: 500;
    }

    .nav-link:hover, .dropdown-item:hover {
        color: #6f4e37 !important;
        text-decoration: underline;
    }
</style> 
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <div>WELCOME TO GLOBAL BEAN CONNECT</div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto"></ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('category') }}">{{ __('Register here') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">       
            <div class="wrapper">    
                <div class="content pt-5">               
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    @include('layouts.scripts')
</body>
</html>