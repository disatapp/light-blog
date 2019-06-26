<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <header>
    </header>
    <body>
        @yield('banner')
        <main class="main" role="main">
        @yield('content')
        </main>

    </body>
    @yield('script')
</html>