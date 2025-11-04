<!DOCTYPE html>
<html lang="en">
    @include('partials.head')
<body style="background: #f6f9ff">
    
    @include('partials.header')
    
    @yield('content')
    
    {{-- @include('partials.footer') --}}
    
</body>

<script src="{{ asset('js/main.js') }}"></script>

</html>