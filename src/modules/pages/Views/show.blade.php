@extends('ui::layouts/cms_internal_layout')

@section('subnav')
    @include('ui::partials/cms_subnav_panel', ['meta' => $meta, 'nav' => $nav])
@stop

@section('content')
</section>
    <div class="row">
        <div class="col-lg-4">
            <section class="panel">
                <div class="panel-heading">
                    Current {{ $page->title }} Template
                </div>
                <div class="panel-body">
                @foreach($sections['page'] as $layout_part => $page_section)
                <div class="col-lg-{{ 12 / intVal(count($sections['page'])) }}">
                    <h3>{{ ucfirst($layout_part) }}</h3>
                    <ol class="sortable" href="/websites/{{ $website->id }}/navigation" data-layout-part="{{ $layout_part }}">
                    @foreach($page_section->items as $item)
                        <li
                            id="menuItem_{{ $item->id }}"
                            data-section-id="{{ $item->id }}"
                            class="item"
                        >
                            <i class="handle fa fa-arrows"> </i>
                            <img src="https://placehold.it/120x120">
                            <div>
                                <a
                                    href="#{{ $meta->base_url.'/'.$item->url }}"
                                    class="no-link"
                                    data-id="{{ $item->label }}"
                                    data-click="{{ $meta->base_url.'/'.$item->url }}"
                                    data-target="#content-edit"
                                    style="display: inline"
                                >
                                    {{ $item->label }}
                                </a>
                            </div>
                            <a
                                data-id="{{$item->id}}"
                                href="{{ $meta->base_url.'/section/'.$item->id }}"
                                class="delete-icon"
                            >
                                <i class="fa fa-trash-o"> </i> Delete
                            </a>
                        </li>
                    @endforeach
                    </ol>
                </div>
                @endforeach
                </div>
            </section>
        </div>
        <div class="col-lg-8" id="content-edit"></div>
    </div>


    @foreach($sections['available'] as $layout_part => $page_section)
        <section class="panel">
            <div class="panel-heading">{{ $page_section->label }}</div>
            <div class="panel-body">
                <ol class="inline-draggable">
                @foreach($page_section->items as $item)
                    <li
                        id="menuItem_{{ $item->name }}"
                        data-section-id="{{ $item->props['id'] }}"
                        class="draggable item"
                    >
                        <i class="handle fa fa-arrows"> </i>
                        <img src="https://placehold.it/120x120">
                        <div>{{ $item->label }}</div>
                    </li>
                @endforeach
                </ol>
            </div>
        </section>
    @endforeach

@stop

@section('scripts')

<script>

$(document).ready(function() {

    var config = {
        deleteClass: '.delete-icon'
    }

    $('.sortable').sortable({
        items: ".item",
        opacity: 0.8,
        helper: "clone",
        cursor: 'move',
        placeholder: "placeholder",
        // connectWith: '.sortable',
        dropOnEmpty: true,
        // revert: 'invalid',
        //
        isValid: function() {

            return true;

        },

        update: function(event, ui) {
            event.preventDefault();

            var sortData = $('.sortable').sortable('serialize');
            var url = '{{ $meta->base_url }}/section';

            // $.ajax({
            //     type: 'POST',
            //     url: url,
            //     data: sortData,
            //     success: function(data) {
            //         $('{{ $meta->data_target }}').html(data);
            //     }
            // })

            return false;
        },

        receive: function(event, ui) {

            var item = $(ui.item[0]);
            var dest = $($(this)[0]);

            var data = {
                layout_part: dest.attr('data-layout-part'),
                section_id: item.attr('data-section-id')
            }

            $.ajax({
                url: '{{ $meta->base_url }}/section',
                type: 'POST',
                data: data,
                success: function(data) {
                    $('{{ $meta->data_target }}').html(data);
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

    $('.item').hover(function() {
        $(this).find(config.deleteClass).stop(true, true).fadeIn();
    }, function() {
        $(this).find(config.deleteClass).stop(true, true).fadeOut();
    })

    $(config.deleteClass).on('click', function(event) {
        event.preventDefault;

        $.ajax({
            url: $(this).attr('href'),
            type: 'post',
            data: {
                _method: 'delete',
                id: $(this).attr('data-id')
            },

            success: function(data) {
                console.log(data);
                $('{{ $meta->data_target }}').html(data);
            }

        })

        return false;
    })
})

</script>

<style>

  .sortable { min-height: 50px; margin-bottom: 5rem;}
  .sortable i, .draggable i { display: inline-block; }
  .sortable div, .draggable div { display: inline-block; }

  .sortable, .draggable { max-width: 100%; }
  .sortable li img { display: none;}
  ol, ul {list-style: none; padding: 0;}
  ol li { display: block; line-height: 20px; border: 1px solid #ddd; margin-bottom: 2px; border-radius: 4px;}
  li > ol { margin-top: 0px; }
  li div { padding: 5px 10px; }
  ol.sortable li.ui-draggable { max-width: 100%; }
  li .handle { background: #ddd; display: inline-block; line-height: 32px; width: 30px; text-align: center; }
  li .handle:hover {cursor: pointer; background: #eee;}

  .placeholder { border: 1px dashed #aaa; height: 30px; width: 100%; background: rgba(175, 238, 238, 0.1); }
  .helper { background: #ddd; width: 100%;}

  .inline-draggable  {}
  .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin-right: 10px;}
  .inline-draggable li .handle { position: absolute; right: -5px; top: -5px; height: 20px; width: 20px; line-height: 20px; font-size: 8px; border-radius: 5px;}
  .inline-draggable li .handle:hover { background: #eee; cursor: pointer;}
  .inline-draggable li div { color: #fff; font-weight: bold; display: inline-height; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.2); }
  .delete-icon {display: none; font-size: 9px; float: right; line-height: 34px; color: red; margin-right: 10px;}
  .delete-icon:hover {}

</style>

@stop