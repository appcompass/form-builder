@extends('ui::layouts/cms_internal_layout')

@section('subnav')

    @include('ui::partials/cms_subnav_panel', ['meta' => $meta, 'nav' => $nav])

@stop

@section('left-panels')

@if(isset($left_panels))

    @each('ui::partials/panel_source_draggable', array_filter($left_panels), 'navmenu');

@endif

{{-- @include('alerts::alerts') --}}

@stop

@section('content')
    {{-- There can be default content here, or we can include instructions, render markdown maybe? --}}
@stop


@section('footer.scripts')

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
            receive: function(event, ui) {}
        }).disableSelection();

        $('.draggable').draggable({
            connectToSortable: ".sortable",
            helper: "clone",
            // revert: "invalid"
        });

    })
</script>
@stop