<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <h4>{{ $meta->show->sub_section_name }}</h4>
                    <ul class="nav nav-pills nav-stacked mail-nav">

                        @foreach($nav->items as $subnav_name => $subnav_content)
                        <li>
                            <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$subnav_content['url'] }}" data-target="#record-detail">
                                <i class="fa {{ $subnav_content['icon'] }}"></i>
                                <span>{{ $subnav_content['label'] }}</span>
                            </a>
                        </li>
                        @endforeach

                    </ul>
                </div>
            </section>

            {{-- @include('alerts::alerts') --}}

        </div>
        <div class="col-sm-9" id="record-detail" data-load="{{ $meta->base_url }}/{{ $record->id }}/edit"></div>
    </div>
<!-- page end-->
</section>