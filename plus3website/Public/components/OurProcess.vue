<template>
  <section v-if="data" class="section-module section-process">
    <div class="row">
      <div class="medium-8 medium-centered columns">
        <div class="section-header">
          <h2 class="section-heading">{{data.title}}</h2>
          <div class="section-desc" v-html="data.description">
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="medium-12 medium-centered columns" id="home-process-svg"></div>
    </div>
  </section><!-- section-process -->
</template>

<script>
  // @TODO: refactor this so that it's cleaner, interactive, and not buggy,
  // and set speed, animation, and other config settings via the CMS UI for this section.
  export default {
    props: ['data'],
    mounted () {
      var home_process = new Snap("#home-process-svg");
      Snap.load('/assets/images/content/home_process.svg', function(svg){
        if (typeof home_process.append === 'function' ) {
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

          // Arrow handling.
          var arrows = home_process.select('#arrows');
          var arrows_bbox = arrows.getBBox();

          function moveTo(i){
              stopLoops();

              if (i >= svg_config.length) {
                  pos = 0;
              }else if(i < 0) {
                  pos = svg_config.length-1;
              }else{
                  pos = i;
              }

              var row = svg_config[pos];
              var old_row = svg_config[old_pos];

              console.log(old_row, row);
              rings.stop();
              home_process.select(old_row.step_id)
              .stop()

              .transform('t'+[0, 0])
              .animate({
                  opacity: 0,
                  transform: 't'+[0, 400]
              }, 500, anim_step);

              rotateRings(row.end, 500);
              // step(old_row.step_id, 0, 0, 400, 500, anim_step);
              step(row.step_id, -400, 1, 0, 500, anim_step);
              animate();
          }
          // Arrows
          var up_arrow_group = home_process.select('#up_arrow_group');
          var up_arrow_container = home_process.select('#up_arrow_container');
          var up_arrow = home_process.select('#up_arrow');
          var down_arrow_group = home_process.select('#down_arrow_group');
          var down_arrow_container = home_process.select('#down_arrow_container');
          var down_arrow = home_process.select('#down_arrow');

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

          up_arrow_group.click(function(e){
              moveTo(pos+1);
          });

          down_arrow_group.click(function(e){
              moveTo(pos-1);
          });
        }
      });
    }
  }
</script>
