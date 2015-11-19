function loadSourceToTarget(obj){
    console.log(obj);
    var req = $.ajax({
        url: obj.url,
        type: 'GET',
    });

    req.fail(function(jqXHR, textStatus, errorThrown){
        console.log(errorThrown);
    });

    req.then(function(data,textStatus,jqXHR){
        if (obj.attribute) {
            $(obj.target).attr(obj.attribute, data);
        }else{
            // there is some odd issue with this blocking future requests to the same element?
            // we'll need to look into this.
            $(obj.target).html(data);
        }
    })

    if (obj.next.url) {
        req.then(function(data,textStatus,jqXHR){
            loadSourceToTarget(obj.next);
        }, function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
        });
    };

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

function loadNavJs(elm){
//     /*==Left Navigation Accordion ==*/
//     if ($.fn.dcAccordion) {
//         elm.find('#nav-accordion').dcAccordion({
//             eventType: 'click',
//             autoClose: true,
//             saveState: true,
//             disableLink: true,
//             speed: 'slow',
//             showCount: false,
//             autoExpand: true,
//             classExpand: 'dcjq-current-parent'
//         });
//     }
//     /*==Slim Scroll ==*/
//     if ($.fn.slimScroll) {
//         elm.find('.event-list').slimscroll({
//             height: '305px',
//             wheelStep: 20
//         });
//         elm.find('.conversation-list').slimscroll({
//             height: '360px',
//             wheelStep: 35
//         });
//         elm.find('.to-do-list').slimscroll({
//             height: '300px',
//             wheelStep: 35
//         });
//     }
//     /*==Nice Scroll ==*/
//     if ($.fn.niceScroll) {


//         elm.find(".leftside-navigation").niceScroll({
//             cursorcolor: "#1FB5AD",
//             cursorborder: "0px solid #fff",
//             cursorborderradius: "0px",
//             cursorwidth: "3px"
//         });

//         elm.find(".leftside-navigation").getNiceScroll().resize();
//         if (elm.find('#sidebar').hasClass('hide-left-bar')) {
//             elm.find(".leftside-navigation").getNiceScroll().hide();
//         }
//         elm.find(".leftside-navigation").getNiceScroll().show();

//         elm.find(".right-stat-bar").niceScroll({
//             cursorcolor: "#1FB5AD",
//             cursorborder: "0px solid #fff",
//             cursorborderradius: "0px",
//             cursorwidth: "3px"
//         });

//     }


//     /*==Easy Pie chart ==*/
//     if ($.fn.easyPieChart) {

//         elm.find('.notification-pie-chart').easyPieChart({
//             onStep: function (from, to, percent) {
//                 $(this.el).find('.percent').text(Math.round(percent));
//             },
//             barColor: "#39b6ac",
//             lineWidth: 3,
//             size: 50,
//             trackColor: "#efefef",
//             scaleColor: "#cccccc"

//         });

//         elm.find('.pc-epie-chart').easyPieChart({
//             onStep: function(from, to, percent) {
//                 $(this.el).find('.percent').text(Math.round(percent));
//             },
//             barColor: "#5bc6f0",
//             lineWidth: 3,
//             size:50,
//             trackColor: "#32323a",
//             scaleColor:"#cccccc"

//         });

//     }

//     /*== SPARKLINE==*/
//     if ($.fn.sparkline) {

//         elm.find(".d-pending").sparkline([3, 1], {
//             type: 'pie',
//             width: '40',
//             height: '40',
//             sliceColors: ['#e1e1e1', '#8175c9']
//         });



//         var sparkLine = function () {
//             $(".sparkline").each(function () {
//                 var $data = $(this).data();
//                 ($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
//                 ($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));

//                 $data.valueSpots = {
//                     '0:': $data.spotColor
//                 };
//                 $(this).sparkline($data.data || "html", $data);


//                 if ($(this).data("compositeData")) {
//                     $spdata.composite = true;
//                     $spdata.minSpotColor = false;
//                     $spdata.maxSpotColor = false;
//                     $spdata.valueSpots = {
//                         '0:': $spdata.spotColor
//                     };
//                     $(this).sparkline($(this).data("compositeData"), $spdata);
//                 };
//             });
//         };

//         var sparkResize;
//         $(window).resize(function (e) {
//             clearTimeout(sparkResize);
//             sparkResize = setTimeout(function () {
//                 sparkLine(true)
//             }, 500);
//         });
//         sparkLine(false);



//     }



//     if ($.fn.plot) {
//         var datatPie = [30, 50];
//         // DONUT
//         $.plot($(".target-sell"), datatPie, {
//             series: {
//                 pie: {
//                     innerRadius: 0.6,
//                     show: true,
//                     label: {
//                         show: false

//                     },
//                     stroke: {
//                         width: .01,
//                         color: '#fff'

//                     }
//                 }




//             },

//             legend: {
//                 show: true
//             },
//             grid: {
//                 hoverable: true,
//                 clickable: true
//             },

//             colors: ["#ff6d60", "#cbcdd9"]
//         });
//     }



//     /*==Collapsible==*/
//     $('.widget-head').on('click',function (e) {
//         var widgetElem = $(this).children('.widget-collapse').children('i');

//         $(this)
//             .next('.widget-container')
//             .slideToggle('slow');
//         if ($(widgetElem).hasClass('ico-minus')) {
//             $(widgetElem).removeClass('ico-minus');
//             $(widgetElem).addClass('ico-plus');
//         } else {
//             $(widgetElem).removeClass('ico-plus');
//             $(widgetElem).addClass('ico-minus');
//         }
//         e.preventDefault();
//     });




//     /*==Sidebar Toggle==*/

//     $(".leftside-navigation .sub-menu > a").on('click',function () {
//         var o = ($(this).offset());
//         var diff = 80 - o.top;
//         if (diff > 0){
//             $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
//         }else{
//             $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
//         }
//     });

//     // tool tips
//     if ($.fn.tooltip) {
//         $('.tooltips').tooltip();
//     };

//     // popovers
//     if ($.fn.popover) {
//         $('.popovers').popover();
//     };


}