(function($) {

    var breakpoints = {large: 1200, medium: 992, small:768 , xsmall:767 };


    /* Navigation
    ---------------------------------------------------------------------- */

    $('.main-nav-trigger').on('click', function() {
        $(this).toggleClass('is-open');
        $('.main-nav').toggleClass('is-open');
    });

    $('.nav-dropdown-arrow').on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().toggleClass('is-open');
    });

    /* Slideshows
    ---------------------------------------------------------------------- */
    $('.work-slideshow').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        arrows: false,
        mobileFirst: true,
        customPaging : function(slider, i) {
            var num = i + 1;
            return '<button type="button" data-role="none" role="button" tabindex="0">0'+ num + '</button>';
        },
    });

    $('.facebook-slideshow').slick({
        centerMode: true,
        centerPadding: '20px',
        infinite:false,
        speed: 300,
        arrows: false,
        mobileFirst: true,
        responsive: [
            {
                breakpoint: breakpoints.xsmall,
                settings: {
                    variableWidth: true,
                    centerMode: false,
                }
            },
            {
                breakpoint: breakpoints.medium - 1,
                settings: {
                    variableWidth: true,
                    centerMode: false,
                    arrows: true,
                    appendArrows: '.facebook-slideshow-controls',
                    prevArrow: '<button type="button" class="slick-prev"><span class="icon-arrow"></span></button>',
                    nextArrow: '<button type="button" class="slick-next"><span class="icon-arrow"></span></button>',
                }
            }

        ]
    });

    $('.review-slideshow').slick({
        fade:true,
        autoplay:true,
        autoplaySpeed: 4000,
        dots: true,
        infinite: true,
        speed: 1000,
        slidesToShow: 1,
        arrows: false
    });

    /* Match Heights
    ---------------------------------------------------------------------- */
    $('.solution-box').matchHeight();
    $('.solution-box-front').matchHeight();
    $('.facebook-slide').matchHeight();
    $('.project-card').matchHeight();

    if ($(window).width() < breakpoints.small) {
        $('.solution-box, .solution-box-front, .facebook-slide, .project-card').matchHeight({ remove: true });
    }

    /* Forms
    ---------------------------------------------------------------------- */

    // Labels
    $('.inside + input:not(:checkbox, :radio), .inside + textarea').on('focus', function() {
        $(this).prev('.inside').removeClass('inside').addClass('outside');
    }).on('focusout', function() {
        if( !$(this).val() ) {
            $(this).prev('.outside').removeClass('outside').addClass('inside');
        }
    });

    // Reveal Next
    $('.checkbox-reveal').on('change', function() {
        if($(this).is(':checked')) {
            $(this).parent().next('.hide').removeClass('hide');
        } else {
            $(this).parent().next('.hide').addClass('hide');
        }
    });

    /* Popups
    ---------------------------------------------------------------------- */
    $('.btn-project, .btn-proposal, .team-popup').magnificPopup({
        type:'inline',
        closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
    });

})(jQuery);


var home_process = new Snap("#home-process-svg");

Snap.load('/assets/images/content/home_process.svg', function(svg){
    home_process.append(svg);

    // Rings
    var rings = home_process.select('#rings');
    var discovery_line = rings.select('#discovery_line');

    // Arrows
    var up_arrow_group = home_process.select('#up_arrow_group');
    var up_arrow_container = home_process.select('#up_arrow_container');
    var up_arrow = home_process.select('#up_arrow');
    var down_arrow_group = home_process.select('#down_arrow_group');
    var down_arrow_container = home_process.select('#down_arrow_container');
    var down_arrow = home_process.select('#down_arrow');

    // Arrow handling.
    up_arrow_group.mouseover(function(e){
        up_arrow_container.addClass('active-arrow-container').removeClass('inactive-arrow-container');
        up_arrow.addClass('active-arrow').removeClass('inactive-arrow');
    }).mouseout(function(e){
        up_arrow_container.addClass('inactive-arrow-container').removeClass('active-arrow-container');
        up_arrow.addClass('inactive-arrow').removeClass('active-arrow');
    });

    down_arrow_group.mouseover(function(e){
        down_arrow_container.addClass('active-arrow-container').removeClass('inactive-arrow-container');
        down_arrow.addClass('active-arrow').removeClass('inactive-arrow');
    }).mouseout(function(e){
        down_arrow_container.addClass('inactive-arrow-container').removeClass('active-arrow-container');
        down_arrow.addClass('inactive-arrow').removeClass('active-arrow');
    });

    // Rotations
    var rings_bbox = rings.getBBox();
    var speed = 3000;
    var pause_duration = 2000;
    var svg_config = [
        {
            line_id: '#discovery_line',
            step_id: '#discovery',
            turn_degrees: 31
        }, {
            line_id: '#client_consultation_line',
            step_id: '#client_consultation',
            turn_degrees: 65.5
        }, {
            line_id: '#kick_off_line',
            step_id: '#kick_off',
            turn_degrees: 90
        }, {
            line_id: '#information_architecture_development_line',
            step_id: '#information_architecture',
            turn_degrees: 128.3
        }, {
            line_id: '#design_line',
            step_id: '#design',
            turn_degrees: 167.8
        }, {
            line_id: '#front_end_development_line',
            step_id: '#frontend_development',
            turn_degrees: 179.7
        }, {
            line_id: '#back_end_development_line',
            step_id: '#backend_development',
            turn_degrees: 252.6
        }, {
            line_id: '#quality_assurance_line',
            step_id: '#quality_assurance',
            turn_degrees: 360
        }
    ];

    // // Design TODO: Launch circle line
    // step_id: '#launch',
    var step = function(row, index, step_count){
        setTimeout(function(){
            home_process.select(row.step_id)
            .animate({
                opacity: 1,
                transform: 't'+[0, 0]
            }, speed/3, mina.linear, function(){

                rings.animate({
                    transform: 'r'+row.turn_degrees+',' + rings_bbox.cx + ',' + rings_bbox.cy
                }, speed, mina.linear);

                setTimeout(function(){
                    home_process.select(row.step_id)
                    .animate({
                        opacity: 0,
                        transform: 't'+[0, 400]
                    }, speed/3, mina.linear, function(){
                        if (index == step_count-1) {
                            run_animation();
                        }
                    });
                }, speed-(speed/3));
            });
        },(speed)*index);
    }

    var run_animation = function(){
        for (var i = 0; i < svg_config.length; i++) {
            curr_row = svg_config[i];
            curr_step_elm = home_process.select(curr_row.step_id);
            curr_step_elm.transform('t0,-400');
            step(curr_row, i, svg_config.length);
        }
    }

    run_animation();
});
