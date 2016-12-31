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


var s1 = new Snap("#design");

// Design.svg
Snap.load('assets/images/our_process/process_icons/design.svg', function(response){
    var design = response;
    s1.append(design);
});

s1.stop().animate({ opacity: 0,transform: 'translate(0,200)'}, 3000, mina.easeout);