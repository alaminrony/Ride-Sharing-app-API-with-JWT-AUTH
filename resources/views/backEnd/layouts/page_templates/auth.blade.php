<div class="wrapper">

    {{-- @include('backEnd.layouts.navbars.auth') --}}
    @include('backEnd.layouts.includes.sidebar')
    <div class="main-panel">
        @include('backEnd.layouts.navbars.navs.auth')
        @yield('content')
        @include('backEnd.layouts.footer')
    </div>
</div>