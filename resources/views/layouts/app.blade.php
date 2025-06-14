<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body>
    <div id="app">
        <main>       
            <div class="wrapper">
        @include('layouts.sidebar')
        
        <div class="main-panel">
            <!-- Navbar -->
          @include('layouts.nav')
            <!-- End Navbar -->
            <div class="content">

             <x-page-header>
             @yield('page-title','Untitled')
            {{--@livewire('counter') example--}}
             </x-page-header>
                
                <div class="container-fluid">
                     @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
        </main>
    </div>
    @include('layouts.scripts')
    @yield('analytics')
    @livewireScripts
</body>
</html>
