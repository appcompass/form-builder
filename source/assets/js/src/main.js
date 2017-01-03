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

    // Rotations
    var rings_bbox = rings.getBBox();
    var int;
    var speed = 6000;
    // var pause_duration = 0;
    // var interval = speed+pause_duration;
    var step_speed = speed/3;
    var pos = 0;
    var is_running = false;
    var anim_circle_enter = mina.elastic;
    var anim_circle_rotate = mina.easeinout;
    var anim_step = mina.linear;

    // // Design TODO: Launch circle line
    // step_id: '#launch',
    var svg_config = [
        {
            line_id: '#discovery_line',
            step_id: '#discovery',
            start: 0,
            end: 31
        }, {
            line_id: '#client_consultation_line',
            step_id: '#client_consultation',
            start: 31,
            end: 65.5
        }, {
            line_id: '#kick_off_line',
            step_id: '#kick_off',
            start: 65.5,
            end: 90
        }, {
            line_id: '#information_architecture_development_line',
            step_id: '#information_architecture',
            start: 90,
            end: 128.3
        }, {
            line_id: '#design_line',
            step_id: '#design',
            start: 128.3,
            end: 167.8
        }, {
            line_id: '#front_end_development_line',
            step_id: '#frontend_development',
            start: 167.8,
            end: 179.7
        }, {
            line_id: '#back_end_development_line',
            step_id: '#backend_development',
            start: 179.7,
            end: 252.6
        }, {
            line_id: '#quality_assurance_line',
            step_id: '#quality_assurance',
            start: 252.6,
            end: 360
        }
    ];

    function turnToTransform(degree){
        return 'r'+degree+',' + rings_bbox.cx + ',' + rings_bbox.cy
    }

    function step(elm, start_pos, opac, end_pos, cb)
    {
        //we scale the step group up for now till we get
        //the directional arrows working properly.
        var s = 1.3;

        home_process.select(elm)
        .transform('s'+[s,s]+'t'+[100, start_pos])
        .animate({
            opacity: opac,
            transform: 's'+[s,s]+'t'+[100, end_pos]
        }, step_speed, anim_step, function(){
            if (cb) {
                cb();
            }
        });
    }

    function animate(){
        int = setInterval(function(){
            var row = svg_config[pos];

            step(row.step_id, (is_running ? -400 : 0), 1, 0, function(){

                is_running = true;
                // If we are at the first position, which is at both 0 and 360 degrees,
                // then lets reset the rings to create a smooth loop effect.
                if (pos == 0) {
                    rings.transform(turnToTransform(row.start));
                }
                // Move rings forward.
                rings.animate({
                    transform: turnToTransform(row.end)
                }, speed, anim_circle_rotate);

                setTimeout(function(){
                    step(row.step_id, 0, 0, 400);
                }, speed-step_speed);

                // Increment or reset the position tracking.
                if (pos === svg_config.length-1) {
                    pos = 0;
                }else{
                    pos++;
                }

            });
        }, speed); //interval
    }

    // function moveTo(i){
    //     // we need to check the config size to allow loop between start and finish.
    //     pos = i;
    //     clearInterval(int);
    //     // we need to be able to fast forward and fast rewind.
    //     animate();
    // }

    function init(){
            var row = svg_config[0];
            rings.transform('t'+[rings_bbox.x, 0]).animate({
                transform: 't'+[0, 0]
            }, speed, anim_circle_enter);
            step(row.step_id, -400, 1, 0);
            animate();
    }

    init();

    // // Arrow handling.

    // // Arrows
    // var up_arrow_group = home_process.select('#up_arrow_group');
    // var up_arrow_container = home_process.select('#up_arrow_container');
    // var up_arrow = home_process.select('#up_arrow');
    // var down_arrow_group = home_process.select('#down_arrow_group');
    // var down_arrow_container = home_process.select('#down_arrow_container');
    // var down_arrow = home_process.select('#down_arrow');

    // up_arrow_group.mouseover(function(e){
    //     up_arrow_container.addClass('active-arrow-container').removeClass('inactive-arrow-container');
    //     up_arrow.addClass('active-arrow').removeClass('inactive-arrow');
    // }).mouseout(function(e){
    //     up_arrow_container.addClass('inactive-arrow-container').removeClass('active-arrow-container');
    //     up_arrow.addClass('inactive-arrow').removeClass('active-arrow');
    // });

    // down_arrow_group.mouseover(function(e){
    //     down_arrow_container.addClass('active-arrow-container').removeClass('inactive-arrow-container');
    //     down_arrow.addClass('active-arrow').removeClass('inactive-arrow');
    // }).mouseout(function(e){
    //     down_arrow_container.addClass('inactive-arrow-container').removeClass('active-arrow-container');
    //     down_arrow.addClass('inactive-arrow').removeClass('active-arrow');
    // });

    // up_arrow_group.click(function(e){
    //     moveTo(pos+1);
    // });

    // down_arrow_group.click(function(e){
    //     moveTo(pos-1);
    // });

});
