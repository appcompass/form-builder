<link rel="stylesheet" href="/assets/ui/js/nestable/jquery.nestable.css">

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-sm-3">
            <section class="panel">
                <div class="panel-body">
                    <h5>{{ $meta->show->sub_section_name }}</h5>
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

            @if(isset($left_panels))

                @foreach($left_panels as $navmenu)

                    <section class="panel">
                        <div class="panel-body">
                            <h5>{{ $navmenu->label }}</h5>

                            <div class="dd" id="nestable_menu">
                                <ul class="nav nav-stacked dd-list">

                                    @foreach($navmenu->items as $item)
                                        <li class="dd-item" data-id="{{ $item->id }}" style="display: inline">
                                            <i class="dd-handle fa fa-arrows-alt"></i>
                                            <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$item->url }}" data-target="#record-detail">
                                                {{ $item->label }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </div>
                    </section>

                @endforeach

            @endif

            {{-- @include('alerts::alerts') --}}

        </div>
        <div class="col-sm-9" id="record-detail" data-load="{{ $meta->base_url }}/{{ $record->id }}/edit"></div>
    </div>
<!-- page end-->
</section>

<script src="/assets/ui/js/nestable/jquery.nestable.js"></script>

<script>
    var Nestable = function() {
        $('#nestable_menu').nestable({

        });
    }();
</script>