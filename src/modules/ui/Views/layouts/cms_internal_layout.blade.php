    <div class="row">
        <div class="col-sm-3">

        @yield('subnav')

        @yield('left-panels')

        </div>

        <div class="col-sm-9" id="record-detail">

          @yield('content')

        </div>
    </div>

    @yield('scripts')