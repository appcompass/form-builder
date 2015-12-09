<section id="alerts-panel" class="panel">
  <div class="panel-body">
    <ul class="nav nav-pills nav-stacked labels-info ">
      <li><h4>Activities Feed: </h4></li>
      <li v-repeat="alert: alerts">
        <a href="#"> <i class="fa fa-comments-o text-muted"></i><span v-text="alert.title"></span><p v-text="alert.message"></p></a>
      </li>
    </ul>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.7/socket.io.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/0.12.16/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.1.16/vue-resource.min.js"></script>

<script>

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
</script>