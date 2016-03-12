<div class="modal fade in" id="photoModal"></div>

<section class="panel">
    <header class="panel-heading">
        <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
        </span>
        Upload Videos
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                {{-- @can('update', $record) --}}
                    {!!
                        Form::model($gallery, [
                            'class' => 'dropzone',
                            'id' => 'dropzone_'.$gallery->id,
                            'method' => 'POST',
                            'data-target' => '#record-detail',
                            'url' => $meta->base_url
                        ])
                    !!}
                    {!! Form::close() !!}
                {{-- @endcan --}}
            </div>
        </div>
    </div>
</section>

@if(!empty($videos->count()))
    <section class="panel">
        <header class="panel-heading">
            Videos in {{ $gallery->name }}
        </header>

        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Bulk Actions:</h4>
                    <a class="btn btn-danger no-link" href="javascript:;" data-bulk-update="/galleries/{{ $gallery->id }}/videos" data-action="delete" data-target="#gallery_{{ $gallery->id }}"><i class="fa fa-times"></i> Delete Selected</a>
                </div>
            </div>
            <hr>
            <div id="gallery_{{ $gallery->id }}" class="media-gal isotope sortable">
                @include('videos::video-grid', ['videos' => $videos, 'is_modal' => false])
            </div>
        </div>
    </section>
@endif

<link href="/assets/galleries/css/dropzone.css" rel="stylesheet">
<script src="/assets/galleries/js/dropzone.js"></script>
<script src="/assets/photos/js/jquery.isotope.js"></script>
<!-- Style Overrides -->
<style>
    .dropzone {
        display: table;
        width: 100%;
        height: 150px;
        min-height: 0;
        padding: 0;
        border: 2px dashed #99cce3;
        background-color: #ebf8ff;
        border-radius: 6px;
    }

    .dropzone .dz-message {
        display: table-cell;
        vertical-align: middle;
        font-size: 24px;
    }

    .bulk_update {
        display: inline-block;
        max-width: 44%;
        margin-bottom: 10px;
    }

    .filters .btn {
        margin-bottom: 4px;
    }

    .media-gal {
        margin-top: 4px;
    }

    .media-gal .item {
        border-radius: 4px;
        width: 100%;
    }

    .media-gal .item:hover {
        background-color: #f8f8f8;
        cursor: move;
    }

    .media-gal .item-image {
        display: block;
        margin-bottom: 8px;
    }

    .media-gal .item-meta {
        font-size: 12px;
        margin-bottom: 8px;
    }

    .media-gal .item-actions > * {
        margin-left: 2px;
    }

    .modal-backdrop {
        position: fixed;
    }

    .icheckbox_square {
        display: inline-block;
        vertical-align: middle;
    }

    .media-gal .item {
        width: 530px;
    }
    .media-gal .item .wistia_embed {
        width: 510px;
        height: 510px;
    }
</style>
<script type="text/javascript">
    $(function() {

        var $container = $('#gallery_{{ $gallery->id }}');

        $container.isotope({
            transformsEnabled: false,
            itemSelector: '.isotope-item',
            onLayout: function(){
                $container.css('overflow', 'visible');
            },
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
        });

        // filter items when filter link is clicked
        $('.filters a').click(function() {
            var selector = $(this).attr('data-filter');
            $container.isotope({filter: selector});
            return false;
        });

        $container.sortable({
            items: ".item",
            opacity: 0.8,
            coneHelperSize: true,
            forcePlaceholderSize: true,
            cursor: 'move',
            tolerance: "pointer", //intersection
            start: function(event, ui) {
                ui.item.addClass('grabbing moving').removeClass('isotope-item');
                ui.placeholder.addClass('starting')
                    .removeClass('moving')
                    .css({
                        top: ui.originalPosition.top,
                        left: ui.originalPosition.left
                    })

                $container.isotope('reloadItems');
            },
            change: function(event, ui) {
                ui.placeholder.removeClass('starting');
                $container.isotope('reloadItems')
                    .isotope({ sortBy: 'original-order'});
            },
            beforeStop: function(event, ui) {
                ui.placeholder.after(ui.item);
            },
            stop: function(event, ui) {
                ui.item.removeClass('grabbing').addClass('isotope-item');
                $container.isotope('reloadItems')
                    .isotope({ sortBy: 'original-order' }, function(){
                        if (!ui.item.is('.grabbing')) {
                            ui.item.removeClass('moving');
                        }
                    });
            },
            update: function(event, ui) {
                var sortData = $container.sortable('serialize');
                $.ajax({
                    url: '/galleries/{{ $gallery->id }}/videos',
                    data: sortData,
                    type: 'POST',
                    error: function(err){
                        console.log(err);
                    },
                    success: function(data){
                        // console.log(data);
                    },
                    complete: function(xhr, status){
                        if (status =='success') {
                            console.log('sort success!');
                        }else{
                            console.log(status);
                        }
                    }
                });

            }
        });

        $container.disableSelection();

        $('.item-actions input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square',
            // increaseArea: '20%' // optional
        });


        $(window).on('resize', function() {
            $container.isotope('reLayout');
        })
    });

    Dropzone.autoDiscover = false;

    $(function() {
        var dz = new Dropzone('#dropzone_{{ $gallery->id }}', {
            maxFilesize: 50000,
            dictDefaultMessage: 'Drop files here or click to upload.'
        });

        dz.on('queuecomplete', function(file) {
            // window.location.reload();
        });
    });
</script>
