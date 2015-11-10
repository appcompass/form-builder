@extends('ui::layouts/cms_internal_layout')

@section('subnav')
<section class="panel">
    <div class="panel-body">
        <h5>{{ $meta->show->sub_section_name }}</h5>
        <ul class="nav nav-pills nav-stacked mail-nav">

            @foreach($nav->items as $subnav_name => $subnav_content)

            <li>
                <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$subnav_content['url'] }}" {!! inlineAttrs($subnav_content->props, 'link') !!}>
                    <i class="fa {{ $subnav_content['icon'] }}"></i>
                    <span>{{ $subnav_content['label'] }}</span>
                </a>
            </li>
            @endforeach

        </ul>
    </div>
</section>
@stop

@section('left-panels')

@if(isset($left_panels))

@foreach(array_filter($left_panels['targets']) as $navmenu)

<section class="panel">
    <div class="panel-body">
        <h5>{{ $navmenu->label }}</h5>

        <div id="">
            <ul class="nav nav-stacked sortable">

                @foreach($navmenu->items as $item)
                <li id="reorder_{{ $item->id }}" class="item" data-id="{{ $item->id }}" style="display: inline">
                    <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$item->url }}" data-target="#record-detail">
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
                    </a>
                </li>
                @endforeach

            </ul>
        </div>

    </div>
</section>

@endforeach

@foreach(array_filter($left_panels['sources']) as $navmenu)

<section class="panel">
    <div class="panel-body">
        <h5>{{ $navmenu->label }}</h5>

        <div id="">
            <ul class="nav nav-stacked">

                @foreach($navmenu->items as $item)
                <li id="reorder_{{ $item->id }}" class="draggable" data-id="{{ $item->id }}" style="display: inline">
                    <a href="#">
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
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

@stop

@section('content')
    <div class="panel">
        <div class="panel-body">
            <h3>Instructions</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error, assumenda neque dolor cum ducimus adipisci velit voluptate quae perferendis! Dolorem rem eius facere deserunt iure saepe nihil aspernatur asperiores minima.</p>
        </div>
    </div>
@stop

<script src="/assets/ui/js/nestable/jquery.nestable.js"></script>

<style>
    .sortable {
        min-height: 50px;
    }

    .ui-sortable-placeholder {
        border: 1px dashed #aaa;
        height: 45px;
        width: 344px;
        background: rgb(253, 253, 253);
    }

    .sortable {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 60%;
    }

    .sortable li {
        margin: 0 3px 3px 3px;
        padding: 0.4em;
        padding-left: 1.5em;
        height: 48px;
    }

    .sortable li span {
        position: absolute;
    }
</style>

<script>
    $(document).ready(function() {

        $('.sortable').sortable({
            items: ".item",
            opacity: 0.8,
            helper: "clone",
            cursor: 'move',
            placeholder: "ui-sortable-placeholder",
            connectWith: '.sortable',
            dropOnEmpty: true,
            receive: function(event, ui) {
                console.log(ui);
                $.ajax({
                    url: 'cp/pages',
                    type: 'POST',
                    success: function(data) {},
                    complete: function(data) {},
                    error: function(error) {},
                })
            }
        }).disableSelection();

        $('.draggable').draggable({
            connectToSortable: ".sortable",
            helper: "clone",
            // revert: "invalid"
        });

    })
</script>