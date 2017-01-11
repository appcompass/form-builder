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
Snap.load('assets/images/content/home_process.svg', function(svg){
    home_process.append(svg);

    // Rings
    var rings = home_process.select('#rings');
    var rings_bbox = rings.getBBox();

    var int;
    var tim;
    var speed = 4000;
    var step_speed = speed/3;
    var pos = 0;
    var in_view = false;
    var is_running = false;
    var step_scale = 1.2;
    var anim_stage = mina.easeinout;
    var anim_circle_rotate = mina.easeinout;
    var anim_step = mina.easeinout;

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

    function step(elm, start_pos, opac, end_pos, step_speed, anim_step, cb)
    {
        home_process.select(elm)
        .transform('s'+[step_scale,step_scale]+'t'+[0, start_pos])
        .animate({
            opacity: opac,
            transform: 's'+[step_scale,step_scale]+'t'+[0, end_pos]
        }, step_speed, anim_step, function(){
            if (cb) {
                cb();
            }
        });
    }

    function stepOut(step_id){
        tim = setTimeout(function(){
            step(step_id, 0, 0, 400, step_speed, anim_step);
        }, speed-step_speed);

    }

    function stageSet(elm, type){
        var bbox = elm.getBBox();
        var parentBbox = elm.parent().getBBox();
        var start_pos = [0,0];
        var end_pos = [0, 0];


        switch(type){
            case 'arrows':
                start_pos = [bbox.w+8, 0];
            break;
            case 'rings':
                start_pos = [bbox.x, 0];
            break;
        }
        elm
        .transform('t'+start_pos)
        .stop()
        .animate({
            transform: 't'+end_pos
        }, step_speed, anim_stage);
    }

    function rotateRings(degrees, speed){
        // Rotate rings.
        rings.animate({
            transform: turnToTransform(degrees)
        }, speed, anim_circle_rotate);
    }

    function animate(){
        int = setInterval(function(){
            var row = svg_config[pos];

            step(row.step_id, (is_running ? -400 : 0), 1, 0, step_speed, anim_step, function(){

                is_running = true;
                // If we are at the first position, which is at both 0 and 360 degrees,
                // then lets reset the rings to create a smooth loop effect.
                if (pos == 0) {
                    rings.transform(turnToTransform(row.start));
                }

                rotateRings(row.end, speed);

                stepOut(row.step_id);

                // Increment or reset the position tracking.
                if (pos === svg_config.length-1) {
                    pos = 0;
                }else{
                    pos++;
                }

            });
        }, speed); //interval
    }
    function stopLoops(){
        clearInterval(int);
        clearTimeout(tim);
    }

    function init(){
        var row = svg_config[0];

        // stageSet(arrows, 'arrows');
        stageSet(rings, 'rings');

        step(row.step_id, -400, 1, 0, step_speed, anim_step);
        animate();
    }

    function reset(){
        stopLoops();
        var bbox = rings.getBBox();


        rings.stop().transform('');

        for (var i = 0; i < svg_config.length; i++) {
            home_process.select(svg_config[i].step_id)
            .stop()
            .transform('')
            .attr({opacity: 0});
        }
    }

    function isInView(elm) {
        var elm_top = elm.getBoundingClientRect().top;
        var elm_bottom = elm.getBoundingClientRect().bottom;

        return elm_top < window.innerHeight && elm_bottom >= 0;
    }

    function viewWatcher(){
        var check = isInView(home_process.node);
        if (check != in_view) {
            in_view = check;
            console.log(in_view);
            if (in_view && !is_running) {
                init();
            }else{
                // Restting the animation doesn't work as expected,
                // will need more time to dig into this one...
                // reset();
            }
        }
    }

    if (document.addEventListener) {
        document.addEventListener('scroll', viewWatcher, false);
    } else if (document.attachEvent) {
        document.attachEvent('on' + 'scroll', viewWatcher);
    }

    // viewWatcher();

    // // Arrow handling.
    // var arrows = home_process.select('#arrows');
    // var arrows_bbox = arrows.getBBox();

    // function moveTo(i){
    //     stopLoops();

    //     if (i >= svg_config.length) {
    //         pos = 0;
    //     }else if(i < 0) {
    //         pos = svg_config.length-1;
    //     }else{
    //         pos = i;
    //     }

    //     var row = svg_config[pos];
    //     var old_row = svg_config[old_pos];

    //     console.log(old_row, row);
    //     rings.stop();
    //     home_process.select(old_row.step_id)
    //     .stop()

    //     .transform('t'+[0, 0])
    //     .animate({
    //         opacity: 0,
    //         transform: 't'+[0, 400]
    //     }, 500, anim_step);

    //     rotateRings(row.end, 500);
    //     // step(old_row.step_id, 0, 0, 400, 500, anim_step);
    //     step(row.step_id, -400, 1, 0, 500, anim_step);
    //     animate();
    // }
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
