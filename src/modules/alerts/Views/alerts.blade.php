<section id="alerts-panel" class="panel">
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked labels-info ">
      <li><h4>Activities Feed: </h4></li>
      <li v-repeat="alert: alerts">
        <a href="#"> <i class="fa fa-comments-o text-muted"></i><span v-text="alert.title"></span><p v-text="alert.message"></p></a>
      </li>
    </ul>
</section>

<script>

  (function(Vue) {

    var socket = io('http://192.168.10.10:3000');

    new Vue({
      el: '#alerts-panel',

      data: {
        'alerts': []
      },

      methods: {

        fetchAlerts: function(hash) {
          this.$http.get('/notifications/alerts/info?hash=' + encodeURIComponent(hash), function(alert) {
            if (alert) {
              this.alerts.unshift(alert);
              this.trimQueue()
            }
          })
        },

        trimQueue: function() {
          if (this.alerts.length > 3) {
            this.alerts.splice(-1, 1);
          }
        }

      },

      ready: function() {

        socket.on('alerts:info', function(hash) {
          this.fetchAlerts(hash);
        }.bind(this));

      }

    });

  })(Vue)

</script>