    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">8</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <li>
                    <p class="">You have 8 pending taskses</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>25% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="45">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Product Delivery</h5>
                                <p>45% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="78">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Payment collection</h5>
                                <p>87% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="60">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info clearfix">
                            <div class="desc pull-left">
                                <h5>Target Sell</h5>
                                <p>33% , Deadline  12 June’13</p>
                            </div>
                                    <span class="notification-pie-chart pull-right" data-percent="90">
                            <span class="percent"></span>
                            </span>
                        </div>
                    </a>
                </li>

                <li class="external">
                    <a href="#">See All Tasks</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
        <!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">4</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <li>
                    <p class="red">You have 4 Mails</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="/assets/ui/images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Jonathan Smith</span>
                                <span class="time">Just now</span>
                                </span>
                                <span class="message">
                                    Hello, this is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="/assets/ui/images/avatar-mini-2.jpg"></span>
                                <span class="subject">
                                <span class="from">Jane Doe</span>
                                <span class="time">2 min ago</span>
                                </span>
                                <span class="message">
                                    Nice admin template
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="/assets/ui/images/avatar-mini-3.jpg"></span>
                                <span class="subject">
                                <span class="from">Tasi sam</span>
                                <span class="time">2 days ago</span>
                                </span>
                                <span class="message">
                                    This is an example msg.
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="/assets/ui/images/avatar-mini.jpg"></span>
                                <span class="subject">
                                <span class="from">Mr. Perfect</span>
                                <span class="time">2 hour ago</span>
                                </span>
                                <span class="message">
                                    Hi there, its a test
                                </span>
                    </a>
                </li>
                <li>
                    <a href="#">See all messages</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end -->

        <!-- notification dropdown start-->
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" v-bind:class="{bounce: animating}">
                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">@{{ alerts.length }}</span>
            </a>
            <ul class="dropdown-menu extended notification" v-notifications v-bind:alerts="alerts">
                <li>
                    <p>Notifications</p>
                </li>
                <li v-for="alert in alerts">
                    <div class="alert alert-info clearfix">
                        <img class="alert-icon" v-if="alert.props.icon" v-bind:src="alert.icon">
                        <span v-else class="alert-icon"><i class="fa fa-bell-o"></i></span>
                        <div class="noti-info">
                            <a href="#"> @{{ alert.message }} </a>
                        </div>
                    </div>
                </li>

            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.6/socket.io.js"></script>

<script>

    var Alert = function AlertConstructor(data) {

        if (data === undefined || data === '') {
            throw "No data";
        }

        this.title = data.title;
        this.message = data.message;
        this.props = JSON.parse(data.props) || undefined;
        this.icon = this.props.icon || undefined;

        return this;
    };

    (function(Vue, io, window) {

        // TODOS
        // v notifications directive takes the channel being watched
        // v craete an app that encmpasses the directive
        //
        Vue.directive('notifications', {
            params: ['alerts'],
            deep: true,
            paramWatchers: {
                alerts: function(val, oldVal) {
                    this.vm.animate();
                }
            },
            bind: function() {},
            update: function() {},
            unbind: function() {}
        });

        var topNotifications = new Vue({
            el: '#top_menu',
            data: {
                socket: undefined,
                animating: false,
                alerts: []
            },
            ready: function() {
                var vm = this;
                this.socket = io('https://cp.bostonpads.dev:3001', {secure: true});
                // this.socket = io({{ env('SOCKET_ADDR', 'default') }} , {secure: true});

                this.socket.on("test-channel", function(data){
                    vm.getAlert(data.hash);
                    // vm.alerts.unshift(message);
                 });
            },
            methods: {
                getAlert: function(hash) {
                    var vm = this;
                    // using Vue $http because in this case we wanna silently fail
                    this.$http.get('/alerts/', {hash: hash}).then(function(response) {
                        try {
                            var alert = new Alert(response.data);
                            vm.alerts.unshift(alert);
                        } catch(e) {
                            console.log(e);
                        }
                    })
                },
                animate: function() {
                    var vm = this;
                    vm.animating = true;

                    setTimeout(function() {
                        vm.animating = false;
                    }, 1000)
                }
            }
        })

    })(Vue, io, window)
</script>


<style>
    a.new_alerts {
        background: rgba(190, 120, 120, 0.8) !important;
        color: white !important;
    }
    @-moz-keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        -moz-transform: translateY(0);
        transform: translateY(0);
      }
      40% {
        -moz-transform: translateY(-30px);
        transform: translateY(-30px);
      }
      60% {
        -moz-transform: translateY(-15px);
        transform: translateY(-15px);
      }
    }
    @-webkit-keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        -webkit-transform: translateY(0);
        transform: translateY(0);
      }
      40% {
        -webkit-transform: translateY(-30px);
        transform: translateY(-30px);
      }
      60% {
        -webkit-transform: translateY(-15px);
        transform: translateY(-15px);
      }
    }
    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        -moz-transform: translateY(0);
        -ms-transform: translateY(0);
        -webkit-transform: translateY(0);
        transform: translateY(0);
      }
      20% {
        -moz-transform: translateY(-30px);
        -ms-transform: translateY(-30px);
        -webkit-transform: translateY(-30px);
        transform: translateY(-30px);
      }
      50% {
        -moz-transform: translateY(-15px);
        -ms-transform: translateY(-15px);
        -webkit-transform: translateY(-15px);
        transform: translateY(-15px);
      }
    }

    .bounce {
      /*-moz-animation: bounce 2s;*/
      /*-webkit-animation: bounce 2s;*/
      animation: bounce 1s;
      animation-iteration-count: 1;
    }

</style>
