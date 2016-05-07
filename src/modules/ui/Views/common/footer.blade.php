@if(empty($login))
    <!--Core js-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.10.1/lodash.min.js"></script> --}}
    <script src="/assets/ui/js/jquery.js"></script>
    <script src="/assets/ui/js/jquery-1.10.2.min.js"></script>
    <script src="/assets/ui/bs3/js/bootstrap.min.js"></script>
    <script src="/assets/ui/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>

    <!--script for this page-->
    <script src="/assets/ui/js/gritter.js" type="text/javascript"></script>
    <script src="/assets/ui/js/jquery.nicescroll.js"></script>

    <script src="/assets/ui/js/jvector-map/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/assets/ui/js/jvector-map/jquery-jvectormap-us-lcc-en.js"></script>
    <script src="/assets/ui/js/gauge/gauge.js"></script>
    <!--clock init-->
    <script src="/assets/ui/js/css3clock/js/css3clock.js"></script>
    <!--Easy Pie Chart-->
    <script src="/assets/ui/js/easypiechart/jquery.easypiechart.js"></script>
    <!--Sparkline Chart-->
    <script src="/assets/ui/js/sparkline/jquery.sparkline.js"></script>
    <!--Morris Chart-->
    <script src="/assets/ui/js/morris-chart/morris.js"></script>
    <script src="/assets/ui/js/morris-chart/raphael-min.js"></script>
    <!--jQuery Flot Chart-->
    <script src="/assets/ui/js/flot-chart/jquery.flot.js"></script>
    <script src="/assets/ui/js/flot-chart/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/ui/js/flot-chart/jquery.flot.resize.js"></script>
    <script src="/assets/ui/js/flot-chart/jquery.flot.pie.resize.js"></script>
    <script src="/assets/ui/js/flot-chart/jquery.flot.animator.min.js"></script>
    <script src="/assets/ui/js/flot-chart/jquery.flot.growraf.js"></script>
    <script src="/assets/ui/js/jquery.customSelect.min.js" ></script>
    <script src="/assets/ui/js/jquery.customSelect.min.js" ></script>
    <!-- wysiwyg editor  -->
    <script src="/assets/ui/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
    <script src="/assets/ui/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/assets/ui/js/iCheck/jquery.icheck.min.js" ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.6.1/vue-resource.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

    <script src="/assets/ui/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>

    <script src="/assets/ui/js/simrou.min.js" ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>

    @yield('scripts.footer')

    <script>
        // i really hope to find a way to move this away from here
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));

        window.fbAsyncInit = function() {
            FB.init({
              appId     : '1308812039134793', // public info
              xfbml     : true,
              status    : true,
              version   : 'v2.5',
              cookie    : true,
              oauth     : true
            });
        };
    </script>


    <script>
        window.pAsyncInit = function() {
            PDK.init({
                appId: "4826197593923006330", // public info
                cookie: true
            });
        };

        (function(d, s, id){
            var js, pjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//assets.pinterest.com/sdk/sdk.js";
            pjs.parentNode.insertBefore(js, pjs);
        }(document, 'script', 'pinterest-jssdk'));
    </script>

    <script>
        var Photo = function(photo) {
            this.id = photo.id;
            this.path = photo.path;
            this.meta = {
                caption: photo.meta.caption || '',
                label: photo.meta.label || '',
                width: photo.meta.width || '',
                height: photo.meta.height || '',
            }
        }

        var Video = function(video) {
            this.id = video.id;
            this.url = video.url;
            this.caption = '';
        }
    </script>


    <script type="text/javascript">



        // temp spot tille we include actual file.
        // examples/source https://gist.github.com/cowboy/1025817#file-jquery-ba-deparam-min-js

        // jQuery Deparam - v0.1.0 - 6/14/2011
        // http://benalman.com/
        // Copyright (c) 2011 Ben Alman; Licensed MIT, GPL
        (function($){var a,b=decodeURIComponent,c=$.deparam=function(a,d){var e={};$.each(a.replace(/\+/g," ").split("&"),function(a,f){var g=f.split("="),h=b(g[0]);if(!!h){var i=b(g[1]||""),j=h.split("]["),k=j.length-1,l=0,m=e;j[0].indexOf("[")>=0&&/\]$/.test(j[k])?(j[k]=j[k].replace(/\]$/,""),j=j.shift().split("[").concat(j),k++):k=0,$.isFunction(d)?i=d(h,i):d&&(i=c.reviver(h,i));if(k)for(;l<=k;l++)h=j[l]!==""?j[l]:m.length,l<k?m=m[h]=m[h]||(isNaN(j[l+1])?{}:[]):m[h]=i;else $.isArray(e[h])?e[h].push(i):h in e?e[h]=[e[h],i]:e[h]=i}});return e};c.reviver=function(b,c){var d={"true":!0,"false":!1,"null":null,"undefined":a};return+c+""===c?+c:c in d?d[c]:c}})(jQuery)


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /**
        *   Maps an array by the specified property
        *
        */
        function mapBy(array, prop) {
            var map = {};
            if (array && array.length) {
                for (var i=0; i < array.length; i++) {
                    map[ array[i][prop] ] = array[i];
                }
            }
            return map;
        }

        @if(empty($nolock))
            // This is where we put the logic which handles auto redirecting the user to the /lock-screen when they have been idle for X seconds.
        @endif

        function loadSourceToTarget(obj){
            var call = $.ajax({
                url: obj.url,
                type: 'GET',
                error: function(err){
                    // Hijacked by the xhr interceptor
                    // openModal('error', err, true);
                },
                success: function(data){
                    if (obj.attribute) {
                        $(obj.target).attr(obj.attribute, data);
                    }else{
                        $(obj.target).html(data);
                    }
                },
                complete: function(xhr, status){
                    // if (status =='success') {
                    //     loadData($(obj.target));
                    // }else{
                    //     console.log(status);
                    // }
                }
            });

            call.done(function(){
                if (obj.next && obj.next.url) {
                    loadSourceToTarget(obj.next);
                };
            })
        }

        function loadData(elm){


            $.each(elm.find('[data-load]'), function(i, e){

                var obj = {
                    target: e,
                    url: $(e).attr('data-load'),
                    attribute: $(e).attr('data-load-self')
                };

                loadSourceToTarget(obj);
            });
        }

        function openModal(title, message, is_error, width_overide){
            var raw = false;
            switch(title){
                case 'success':
                    title = 'Success!';
                break;
                case 'info':
                    title = 'Heads up!';
                break;
                case 'warning':
                    title = 'Warning!';
                break;
                case 'error':
                    title = 'Failure!';
                    raw = true;
                break;

            }

            message = typeof message == 'string' ? message : '<pre>' + JSON.stringify(message, null, 4) + '</pre>' ;

            $('#modal-alert').find('h4 span').text(title);
            $('#modal-alert').find('.message').html(message);

            if (width_overide) {
                $('#modal-alert').find('.modal-dialog').width(width_overide);
            }
            if (is_error) {
                $('#modal-alert').addClass('error-modal')
            };

            $('#modal-alert').modal('show');
        }

        function draggableSortableInit(config){
            var router = new Simrou();
            var sender = null;
            $('.sortable').sortable({
                items: ".item",
                opacity: 0.8,
                helper: "clone",
                cursor: 'move',
                placeholder: "placeholder",
                dropOnEmpty: true,
                receive: function(event, ui) {
                    // this is set so that update is skipped.
                    sender = ui.sender;

                    var item = $(ui.item[0]);
                    var dest = $($(this)[0]);

                    var data = {};

                    data['add'] = true;
                    data['layout_part'] = dest.attr(config.to_sort_target);
                    data['section_id'] = item.attr(config.to_sort_elm);

                    $.ajax({
                        url: config.resource,
                        type: 'POST',
                        data: data,
                        success: function(data) {
                            window.location.reload();
                        },
                        complete: function(data) {},
                        error: function(error) {},
                    });
                },
                update: function(event, ui) {
                    event.preventDefault();
                    if (!sender) {
                        var sortData = $.deparam($(this).sortable('serialize'));

                        var item = $(ui.item[0]).find('a[data-action="link"]');

                        if (item.attr('data-click')) {
                            sortData['redirect'] = item.attr('data-click');
                        };

                        $.ajax({
                            type: 'post',
                            url: config.resource,
                            data: sortData,
                            success: function(data) {
                                router.navigate(data.data);
                            }
                        })
                        sender = null;
                    };
                    return false;
                }
            }).disableSelection();

            $('.draggable').draggable({
                connectToSortable: ".sortable",
                helper: "clone",
            });
        }

        $(document).ready(function () {
            var alertModal = $('#modal-alert');

            $(this).ajaxStart(function(){
                openModal('Loading', 'Loading Please wait..');
            });

            $(this).ajaxStop(function(){
                if (!alertModal.hasClass('error-modal')) {
                    alertModal.modal('hide');
                };
            });
            // Added this replacing the native XMLHttpRequest XHR Interceptor since it's not as stable/consistent as jquery's handling of ajax events.
            // The downside is though that we can't use vue-resource, and instead have to use jquery's ajax methods.  It's unfortunate but jQuery actually has
            // better support for handling consecutive ajax events (i.e. do something on the first request, and do something else when the very last request is finished)
            $(this).ajaxError(function(event, xhr, settings, error){
                switch (xhr.status) {
                    case 403:
                       sweetAlert("Unauthorized", "You are not authorized to view this resource", "error");
                        break;
                    case 404:
                       sweetAlert("Resource Not Found", "The Resource you are looking for isn't there!", "error");
                        break;
                    case 422:
                        response = JSON.parse(xhr.responseText);
                        data = response.data;
                        error_string = '';
                        for (var prop in data) {
                            if (Object.prototype.hasOwnProperty.call(data, prop)) {
                                error_string += data[prop].join('<br>');
                            }
                        }
                        error_string += '<br>';
                        openModal('Validation Error!', error_string, true);
                        break;
                    case 500:
                        sweetAlert({
                            title: xhr.statusText,
                            text: error, //xhr.responseText
                            type: 'error',
                            html: true,
                        });

                        openModal('error', xhr.responseText, true, 1000);
                        break;
                }
            });

            alertModal.on('hidden.bs.modal', function (e) {
                alertModal.removeClass('error-modal');
                alertModal.find('h4 span').text('');
                alertModal.find('.message').text('');
            });

            var router = new Simrou();

            router.addRoute('*sp').get(function(e, params){
                var req = $.ajax({
                    url: '/request-meta',
                    type: 'post',
                    data: {
                        url: params.sp
                    }});

                req.done(function(data){
                    if (data.success) {
                        loadSourceToTarget(data.data);
                    }

                });
            });

            router.start('/dashboard');

            // $(document).on('click', 'a', function(e){
            //     e.preventDefault();
            //     var url = $(this).attr('href');
            //     if (url) {
            //         router.navigate(url);
            //     };
            // });


            if ($.fn.niceScroll) {
                $('.sidebar-toggle-box .fa-bars').on('click',function (e) {

                    $(".leftside-navigation").niceScroll({
                        cursorcolor: "#1FB5AD",
                        cursorborder: "0px solid #fff",
                        cursorborderradius: "0px",
                        cursorwidth: "3px"
                    });

                    $('#sidebar').toggleClass('hide-left-bar');
                    if ($('#sidebar').hasClass('hide-left-bar')) {
                        $(".leftside-navigation").getNiceScroll().hide();
                    }
                    $(".leftside-navigation").getNiceScroll().show();
                    $('#main-content').toggleClass('merge-left');
                    e.stopPropagation();
                    if ($('#container').hasClass('open-right-panel')) {
                        $('#container').removeClass('open-right-panel')
                    }
                    if ($('.right-sidebar').hasClass('open-right-bar')) {
                        $('.right-sidebar').removeClass('open-right-bar')
                    }

                    if ($('.header').hasClass('merge-header')) {
                        $('.header').removeClass('merge-header')
                    }


                });
            };

            $(document).on('click', '.toggle-right-box .fa-bars', function (e) {
                $('#container').toggleClass('open-right-panel');
                $('.right-sidebar').toggleClass('open-right-bar');
                $('.header').toggleClass('merge-header');

                e.stopPropagation();
            });

            $(document).on('click', '.header, #main-content, #sidebar', function () {
                if ($('#container').hasClass('open-right-panel')) {
                    $('#container').removeClass('open-right-panel')
                }
                if ($('.right-sidebar').hasClass('open-right-bar')) {
                    $('.right-sidebar').removeClass('open-right-bar')
                }

                if ($('.header').hasClass('merge-header')) {
                    $('.header').removeClass('merge-header')
                }
            });

            $(document).on('click', '.panel .tools .fa', function () {
                var el = $(this).parents(".panel").first().find('.panel-body');
                if ($(this).hasClass("fa-chevron-down")) {
                    $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                    el.slideUp(200);
                } else if ($(this).hasClass("fa-chevron-up")) {
                    $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                    el.slideDown(200); }
            });

            $(document).on('click', '.panel .tools .fa-times', function () {
                $(this).parents(".panel").parent().remove();
            });

            loadData($(document));

            $(document).on('click', 'a[href]:not(.no-link)', function(e) {
                e.preventDefault();

                var action = $(this).attr('data-action');
                var url = $(this).attr('data-click');
                var inject = $(this).attr('data-inject-area');
                var href = $(this).attr('href');

                switch(action){
                    case 'clone':

                        $.post(url, {
                            obj_name: $(this).attr('data-object-name'),
                            obj_id: $(this).attr('data-object-id'),
                            obj_redirect: $(this).attr('data-object-redirect')
                        }, function(res) {
                            if (res.success) {
                                router.navigate(res.data);
                            }else{
                                openModal('error', res.message, true);
                            }

                        });

                        break;
                    case 'modal-delete':
                        $.post(url, {
                            resource: $(this).attr('data-delete')
                        }, function(data) {
                            $(inject).html(data);
                        });
                        break;
                    case 'modal-edit':
                        $.get(url, function(data) {
                            $(inject).html(data);
                        });
                        break;
                    default:
                        if (href != 'javascript:;') {
                            if ($(this).attr('href')) {
                                router.navigate(href);
                            };
                        };
                        break;
                }

            });

            // $(document).on('click', 'a[href]:not(.no-link)', function(e){
            //  e.preventDefault();

   //              var href = $(this).attr('href');

   //              if (href != 'javascript:;') {
   //                  var obj = {
   //                      target: $(this).attr('data-target'),
   //                      url: href
   //                  };
   //                  if ($(this).attr('href')) {
   //                      router.navigate(obj.url);
   //                      // loadSourceToTarget(obj);
   //                      // window.history.pushState({"page":obj.url},"", '#'+obj.url);
   //                  };
   //              };
            // });

            $(document).on('click', '[data-bulk-update]', function(e){
                e.preventDefault();
                var elm = $(this);
                var target = elm.attr('data-target');
                var source = elm.attr('data-bulk-update');
                var action = elm.attr('data-action');
                var withVals = elm.attr('data-with');
                var selectedObjects = {
                    bulk: action,
                    ids: $(target).find('[name="bulk_edit"]:checked').map(function(){
                        return this.value;
                    }).get()
                }
                $(withVals).each(function(i, field){
                    if (field.value.length != '') {
                        selectedObjects[field.name] = field.value;
                    };
                });
                $.ajax({
                    url: source,
                    type: 'POST',
                    data: selectedObjects,
                    error: function(err){
                        openModal('error', err, true);
                    },
                    success: function(res){
                        if (res.success) {
                            router.navigate(res.data);
                        }else{
                            openModal('error', res.message, true);
                        }
                        // $(target).html(data);
                    },
                    complete: function(xhr, status){
                        // if (status =='success') {
                        //     loadData($(target));
                        // }else{
                        //     openModal('error', status, true);
                        // }
                    }
                });
            });

            $(document).on('change', '.ajax-form input', function(e){
                $(this).parents('.form-group').removeClass('has-error');
                $(this).next('.input-error').remove();
            });

            $(document).on('submit', '.ajax-form', function(e){
                e.preventDefault();

                var form = $(this);
                var target = form.attr('data-target');
                var action = form.attr('action');
                var formData = new FormData(form[0]);

                if (form.data('loading') === true) {
                    return;
                }

                form.data('loading', true);

                form.find('.input-error').remove();
                form.find('.form-group').removeClass('has-error');

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    error: function(err){
                        if( err.status === 401)
                            router.navigate('/login');
                        if( err.status === 422) {
                            var errors = err.responseJSON;
                            $.each(errors, function(key, val){
                                field = form.find("[name='"+key+"']");
                                if (field.length > 0) {
                                    field.parents('.form-group').addClass('has-error');
                                    $('<span class="help-block input-error">'+val.join('<br/>')+'</em></span>').insertAfter(field);
                                }else{
                                    openModal(key+' error', val.join('<br/>'), true);
                                }
                            });
                        } else {
                            openModal('error', err, true);
                        }
                        form.data('loading', false);
                    },
                    success: function(res){
                        form.data('loading', false);

                        if (res.success) {
                            if (form.hasClass('modal-form')) {
                                $('#modal-edit').modal('hide');
                            };
                            router.navigate(res.data);
                        }else{
                            openModal('error', res.message, true);
                        }
                    },
                    complete: function(xhr, status){
                        form.data('loading', false);
                    }
                });
            });
        });
    </script>
@else
    @yield('scripts.footer')
@endif
</body>
</html>
