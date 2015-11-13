@extends('ui::layouts/cms_internal_layout')

@section('subnav')

    @include('ui::partials/cms_subnav_panel', ['meta' => $meta, 'nav' => $nav])

@stop

@section('left-panels')

    @if(isset($left_panels))

        @foreach(array_filter($left_panels) as $navmenu)

            @include('ui::partials/cms_left_panels_sortable_draggable', ['meta' => $meta, 'navmenu' => $navmenu])

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

{{-- <script src="/assets/ui/js/nestable/jquery.nestable.js"></script> --}}

<style>
    .sortable {min-height: 50px; }
    .ui-sortable-placeholder {border: 1px dashed #aaa; height: 45px; width: 90%; background: rgb(253, 253, 253); }
    .sortable {list-style-type: none; margin: 0; padding: 0; width: 90%; }
    .sortable li {padding: 0.4em; height: 48px; }
    .sortable li span {position: absolute; }
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
            // revert: 'invalid',

            update: function(event, ui) {
                event.preventDefault();

                var sortData = $('.sortable').sortable('serialize');
                var url = '{{ $meta->base_url."/".$record->id."/section" }}';

                console.log(url)

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: sortData,
                    success: function(data) {
                        $('#main-content').html(data);
                    }
                })

                return false;
            },

            receive: function(event, ui) {

                var sectionName = $(ui.item[0]).attr('data-id');

                $.ajax({
                    url: "cp/pages/{{ $record->id}}/section",
                    type: 'POST',
                    data: {'section_name': sectionName},
                    success: function(data) {
                        $('#main-content').html(data);
                    },
                    complete: function(data) {},
                    error: function(error) {},
                })
            }
        }).disableSelection();

        $('.draggable').draggable({
            connectToSortable: ".sortable",
            helper: "clone",
        });

    })
</script>