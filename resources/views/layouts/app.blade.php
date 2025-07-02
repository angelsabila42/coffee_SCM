<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')
<body>

    <div>
        <main>       
            <div id="wrapper" x-data= "sideBar">
                @include('layouts.sidebar2')
        
                <div class="main-panel" x-transition:enter = transition: all 0.25s ease-in-out,
                x-transition:leave = transition: all 0.25s ease-in-out>

                    <!-- Navbar -->
                    @include('layouts.nav')
                    <!-- End Navbar -->

                    <x-session-message/>

                    <div class="content">
                        <x-page-header >
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                            @yield('page-title')
                            @yield('report-btn')
                        </div>
                        {{--@livewire('counter') example--}}
                        </x-page-header>
                
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    </div>

                    @include('layouts.footer')
                </div>
              </div>
        </main>
    </div>
    @include('layouts.scripts.scripts')
    @include('layouts.scripts.chart_scripts')
</body>
</html>
