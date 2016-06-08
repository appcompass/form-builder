<ul class="nav top-menu">

    <li id="header_notification_bar" class="dropdown">
        <notifier
            v-bind:channel="'auth_events'"
            v-bind:alerts="alerts"
            v-bind:socket="socket"
            icon="fa-user"
        ></notifier>
    </li>

    <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <actions
                v-bind:channel="'media_actions'"
                v-bind:alerts="alerts"
                v-bind:socket="socket"
                icon="fa-list"
            ></actions>
        </a>
    </li>

<!--     <li id="header_inbox_bar" class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-important">0</span>
        </a>
        <ul class="dropdown-menu extended inbox">
            <li>
                <p class="red">You have 0 Mails</p>
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
                <a href="#">See all messages</a>
            </li>
        </ul>
    </li>
 -->    <!-- inbox dropdown end -->
</ul>


        <!-- <ul class="dropdown-menu extended tasks-bar"> -->
<!--             <ul class="dropdown-menu extended inbox" v-notifier v-bind:channel="media_actions" v-bind:alerts="alerts" v-bind:socket="socket">
            <li>
                <p class="">You have 0 pending taskses</p>
            </li>

            <li v-for="alert in alerts['media_actions']">
                <div class="alert alert-info clearfix">
                    <img class="alert-icon" v-if="alert.props.icon" v-bind:src="alert.icon">
                    <span v-else class="alert-icon"><i class="fa fa-bell-o"></i></span>
                    <div class="noti-info">
                        <a href="#"> @{{ alert.message }} </a>
                    </div>
                </div>
            </li> -->

<!--                 <li>
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
             <li class="external">
                <a href="#">See All Tasks</a>
            </li>
        </ul>
    </li> -->
    <!-- settings end -->
    <!-- inbox dropdown start-->

<!--  notification end -->

<template id="notifier">
        <a data-toggle="dropdown" class="dropdown-toggle" v-bind:class="{bounce: $parent.animating}">
            <i class="fa fa-user"></i>
            <span class="badge bg-warning">@{{ alerts[channel].length }}</span>
        </a>
        <ul class="dropdown-menu extended inbox">
            <li>
                <p>Notifications</p>
            </li>

            <li v-for="alert in alerts[channel]">
                <a href="#">
                    <span class="photo" v-if="alert.icon">
                        <img alt="avatar" v-bind:src="alert.icon">
                    </span>
                    <span v-else><i class="fa fa-bell-o"></i></span>

                    <span class="subject">
                        <span class="from">@{{ alert.title }}</span>
                        <span class="time">@{{ alert.datetime.format('hh:mm:ss') }}</span>
                    </span>

                    <span class="message">@{{ alert.message }}</span>
                </a>
            </li>

        </ul>
</template>

<template id="actions">
        <a data-toggle="dropdown" class="dropdown-toggle" v-bind:class="{bounce: $parent.animating}">
            <i class="fa fa-list"></i>
            <span class="badge bg-success">@{{ alerts[channel].length }}</span>
        </a>
        <ul class="dropdown-menu extended inbox">
            <li>
                <p>Notifications</p>
            </li>

            <li v-for="alert in alerts[channel]">
                <a href="#">
                    <span class="subject">
                        <span class="from">@{{ alert.title }}</span>
                        <span class="time">@{{ alert.datetime.format('hh:mm:ss') }}</span>
                    </span>

                    <span class="message">@{{ alert.message }}</span>
                </a>
            </li>

        </ul>
</template>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.6/socket.io.js"></script>

<script>

    var Alert = function AlertConstructor(data) {

        if (data === undefined || data === '') {
            throw "No data";
        }

        console.log(data);

        this.title = data.title;
        this.message = data.message;
        this.props = data.props || undefined;
        this.icon = this.props && this.props.icon ? this.props.icon : undefined;
        this.datetime = moment(data.updated_at);
        this.read = false; // @TODO get it from pivot and attach
        this.channels = data.channels.split(' ');

        return this;
    };

    (function(Vue, io, window) {

        /**
        *   Vue - Default Notifier component - Draft
        *
        */
        var Notifier = Vue.extend({
            template: '#notifier',
            props: ['alerts', 'socket', 'channel', 'icon'],
            ready: function() {
                var vm = this;
                vm.socket.on(vm.channel, function(data) {
                    vm.$parent.getAlert(data.id);
                })
            }
        })

        Vue.component('notifier', Notifier);

        /**
        *   Vue - Default Notifier component - Draft
        *
        */
        var Actions = Vue.extend({
            template: '#actions',
            props: ['alerts', 'socket', 'channel', 'icon'],
            ready: function() {
                var vm = this;
                vm.socket.on(vm.channel, function(data) {
                    vm.$parent.getAlert(data.id);
                })
            }
        })

        Vue.component('actions', Actions);

        /**
        *   Vue - Top Notifications
        *
        */
        var topNotifications = new Vue({
            el: '#top_menu',
            data: {
                socket: undefined,
                animating: false,
                alerts: {
                    auth_events: [],
                    media_actions: [],
                }
            },
            created: function() {
                var vm = this;
                // this.socket = io({{ env('SOCKET_ADDR', 'default') }} , {secure: true});
                vm.socket = io('https://cp.bostonpads.dev:3001', {secure: true});
                vm.init();
            },
            methods: {
                init: function() {
                    var vm = this;
                    vm.$http.get('/alerts', {}).then(function(response) {
                        if (!response.data) { return; }
                        response.data.forEach(function(alertData) {
                            vm.pushToChannels(new Alert(alertData));
                        });
                    });
                },
                pushToChannels: function(alert) {
                    var vm = this;
                    alert.channels.forEach(function(channel) {
                        if (!vm.alerts[channel]) {
                            vm.alerts[channel] = [];
                        }
                        vm.alerts[channel].unshift(alert);
                    })
                },
                getAlert: function(alert_id) {
                    var vm = this;
                    // using Vue $http because in this case we wanna silently fail
                    this.$http.get('/alerts/', {alert_id: alert_id}).then(function(response) {
                        try {
                            vm.pushToChannels(new Alert(response.data));
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
