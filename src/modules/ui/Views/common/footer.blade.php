@if(empty($login))
	<!--Core js-->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.5.2/underscore-min.js"></script>
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
	<!-- iCheck -->
	<script src="/assets/ui/js/iCheck/jquery.icheck.min.js" ></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.16/vue.min.js"></script>

    <script src="/assets/ui/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>

    <script src="/assets/ui/js/simrou.min.js" ></script>

	@yield('scripts.footer')

	<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		@if(empty($nolock))
			// This is where we put the logic which handles auto redirecting the user to the /lock-screen when they have been idle for X seconds.
		@endif

		function loadNavJs(elm){
			/*==Left Navigation Accordion ==*/
			if ($.fn.dcAccordion) {
				elm.find('#nav-accordion').dcAccordion({
					eventType: 'click',
					autoClose: true,
					saveState: true,
					disableLink: true,
					speed: 'slow',
					showCount: false,
					autoExpand: true,
					classExpand: 'dcjq-current-parent'
				});
			}
			/*==Slim Scroll ==*/
			if ($.fn.slimScroll) {
				elm.find('.event-list').slimscroll({
					height: '305px',
					wheelStep: 20
				});
				elm.find('.conversation-list').slimscroll({
					height: '360px',
					wheelStep: 35
				});
				elm.find('.to-do-list').slimscroll({
					height: '300px',
					wheelStep: 35
				});
			}
			/*==Nice Scroll ==*/
			if ($.fn.niceScroll) {


				elm.find(".leftside-navigation").niceScroll({
					cursorcolor: "#1FB5AD",
					cursorborder: "0px solid #fff",
					cursorborderradius: "0px",
					cursorwidth: "3px"
				});

				elm.find(".leftside-navigation").getNiceScroll().resize();
				if (elm.find('#sidebar').hasClass('hide-left-bar')) {
					elm.find(".leftside-navigation").getNiceScroll().hide();
				}
				elm.find(".leftside-navigation").getNiceScroll().show();

				elm.find(".right-stat-bar").niceScroll({
					cursorcolor: "#1FB5AD",
					cursorborder: "0px solid #fff",
					cursorborderradius: "0px",
					cursorwidth: "3px"
				});

			}


			/*==Easy Pie chart ==*/
			if ($.fn.easyPieChart) {

				elm.find('.notification-pie-chart').easyPieChart({
					onStep: function (from, to, percent) {
						$(this.el).find('.percent').text(Math.round(percent));
					},
					barColor: "#39b6ac",
					lineWidth: 3,
					size: 50,
					trackColor: "#efefef",
					scaleColor: "#cccccc"

				});

				elm.find('.pc-epie-chart').easyPieChart({
					onStep: function(from, to, percent) {
						$(this.el).find('.percent').text(Math.round(percent));
					},
					barColor: "#5bc6f0",
					lineWidth: 3,
					size:50,
					trackColor: "#32323a",
					scaleColor:"#cccccc"

				});

			}

			/*== SPARKLINE==*/
			if ($.fn.sparkline) {

				elm.find(".d-pending").sparkline([3, 1], {
					type: 'pie',
					width: '40',
					height: '40',
					sliceColors: ['#e1e1e1', '#8175c9']
				});



				var sparkLine = function () {
					$(".sparkline").each(function () {
						var $data = $(this).data();
						($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
						($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

						$data.valueSpots = {
							'0:': $data.spotColor
						};
						$(this).sparkline($data.data || "html", $data);


						if ($(this).data("compositeData")) {
							$spdata.composite = true;
							$spdata.minSpotColor = false;
							$spdata.maxSpotColor = false;
							$spdata.valueSpots = {
								'0:': $spdata.spotColor
							};
							$(this).sparkline($(this).data("compositeData"), $spdata);
						};
					});
				};

				var sparkResize;
				$(window).resize(function (e) {
					clearTimeout(sparkResize);
					sparkResize = setTimeout(function () {
						sparkLine(true)
					}, 500);
				});
				sparkLine(false);



			}



			if ($.fn.plot) {
				var datatPie = [30, 50];
				// DONUT
				$.plot($(".target-sell"), datatPie, {
					series: {
						pie: {
							innerRadius: 0.6,
							show: true,
							label: {
								show: false

							},
							stroke: {
								width: .01,
								color: '#fff'

							}
						}




					},

					legend: {
						show: true
					},
					grid: {
						hoverable: true,
						clickable: true
					},

					colors: ["#ff6d60", "#cbcdd9"]
				});
			}



			/*==Collapsible==*/
			$('.widget-head').on('click',function (e) {
				var widgetElem = $(this).children('.widget-collapse').children('i');

				$(this)
					.next('.widget-container')
					.slideToggle('slow');
				if ($(widgetElem).hasClass('ico-minus')) {
					$(widgetElem).removeClass('ico-minus');
					$(widgetElem).addClass('ico-plus');
				} else {
					$(widgetElem).removeClass('ico-plus');
					$(widgetElem).addClass('ico-minus');
				}
				e.preventDefault();
			});




			/*==Sidebar Toggle==*/

			$(".leftside-navigation .sub-menu > a").on('click',function () {
				var o = ($(this).offset());
				var diff = 80 - o.top;
				if (diff > 0){
					$(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
				}else{
					$(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
				}
			});

			// tool tips
			if ($.fn.tooltip) {
				$('.tooltips').tooltip();
			};

			// popovers
			if ($.fn.popover) {
				$('.popovers').popover();
			};


		}

        function loadSourceToTarget(obj){
            var call = $.ajax({
                url: obj.url,
                type: 'GET',
                error: function(err){
                    console.log(err);
                    notify('error', err, true);
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
                    //     loadNavJs($(obj.target));
                    //     loadData($(obj.target));
                    // }else{
                    //     console.log(status);
                    // }
                }
            });

            call.done(function(){
                if (obj.next && obj.next.url) {
                    loadSourceToTarget(obj.next, true);
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

        function notify(title, message, is_error){
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
                break;

            }

            $('#modal-alert').find('h4 span').text(title);
            $('#modal-alert').find('.message').text(message);

            if (is_error) {
                $('#modal-alert').addClass('error-modal')
            };

            $('#modal-alert').modal('show');
        }



		$(document).ready(function () {
            var alertModal = $('#modal-alert');

            $(this).ajaxStart(function(){
                notify('Loading', 'Loading Please wait..');
            });

            $(this).ajaxStop(function(){
                if (!alertModal.hasClass('error-modal')) {
                    alertModal.modal('hide');
                };
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
                    }else{
                        notify('error', data.message, true);
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
				var el = $(this).parents(".panel").children(".panel-body");
				if ($(this).hasClass("fa-chevron-down")) {
					$(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
					el.slideUp(200);
				} else {
					$(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
					el.slideDown(200); }
			});

			$(document).on('click', '.panel .tools .fa-times', function () {
				$(this).parents(".panel").parent().remove();
			});

			loadData($(document));

			$(document).on('click', 'a[href]:not(.no-link)', function(e){
				e.preventDefault();
                var obj = {
                    target: $(this).attr('data-target'),
                    url: $(this).attr('href')
                };
                console.log(obj.url);
                if ($(this).attr('href')) {
                    router.navigate(obj.url);
                    // loadSourceToTarget(obj);
                    // window.history.pushState({"page":obj.url},"", '#'+obj.url);
                };
			});

            $(document).on('click', '[data-bulk-update]', function(e){
                e.preventDefault();
                var elm = $(this);
                var target = elm.attr('data-target');
                var url = elm.attr('data-bulk-update');
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
                        notify('error', err, true);
                    },
                    success: function(data){
                        $(target).html(data);
                    },
                    complete: function(xhr, status){
                        if (status =='success') {
                            loadNavJs($(target));
                            loadData($(target));
                        }else{
                            notify('error', status, true);
                        }
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
                            console.log(errors);
                            $.each(errors, function(key, val){
                                field = form.find("[name='"+key+"']");
                                field.parents('.form-group').addClass('has-error');
                                $('<span class="help-block input-error">'+val.join('<br/>')+'</em></span>').insertAfter(field);
                            });
                        } else {
                            notify('error', err, true);
                        }
                        form.data('loading', false);
					},
					success: function(res){
                        form.data('loading', false);

                        if (res.success) {
                            router.navigate(res.data);
                        }else{
                            notify('error', res.message, true);
                        }
					},
					complete: function(xhr, status){
						form.data('loading', false);
					}
				});
			});
		});
	</script>
@endif
</body>
</html>
