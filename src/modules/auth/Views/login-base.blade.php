@include("ui::common.header", ['bodyClass' => 'login-body'])
    <div class="container">
        @yield('content')
    </div>
@include("ui::common.footer", ['nolock' => true, 'login' => true])