<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <div class="panel-body profile-information">
                    <div class="col-md-3">
                        <div class="profile-pic text-center">
                            <img alt="" src="" data-load="/user-avatar/160" data-load-self="src">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-desk">
                            <h1 data-load="/user-full-name"></h1>
                            <span class="text-muted">User Profile</span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading tab-bg-dark-navy-blue">
                    <ul class="nav nav-tabs nav-justified ">
                        {{--
                        <li class="active">
                            <a data-toggle="tab" href="#overview" class="no-link">
                                Overview
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#activity-history" class="no-link">
                                Activiy History
                            </a>
                        </li>
                         --}}
                        <li class="active">
                            <a data-toggle="tab" href="#settings" class="no-link">
                                User Settings
                            </a>
                        </li>
                        @foreach($data as $profile)
                        <li>
                            <a data-toggle="tab" href="#{{str_replace(' ', '_', strtolower($profile->profile_name))}}" class="no-link">
                                {{$profile->profile_name}} Settings
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content tasi-tab">
                        {{--
                        <div id="overview" class="tab-pane active">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="recent-act">
                                        <h1>Recent Activity</h1>
                                        <div class="activity-icon terques">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div class="activity-desk">
                                            <h2>1 Hour Ago</h2>
                                            <p>An event that happened an hour ago.</p>
                                        </div>
                                        <div class="activity-icon red">
                                            <i class="fa fa-beer"></i>
                                        </div>
                                        <div class="activity-desk">
                                            <h2 class="red">2 Hour Ago</h2>
                                            <p>Another event that happened 2 hours ago that has a <a href="#" class="terques">link</a> associated with it</p>
                                        </div>
                                        <div class="activity-icon purple">
                                            <i class="fa fa-tags"></i>
                                        </div>
                                        <div class="activity-desk">
                                            <h2 class="purple">Today</h2>
                                            <p>3 photo Uploaded to xyz human readable model/resource name</p>
                                            <div class="photo-gl">
                                                <a href="#">
                                                    <img src="" alt=""/>
                                                </a>
                                                <a href="#">
                                                    <img src="" alt=""/>
                                                </a>
                                                <a href="#">
                                                    <img src="" alt=""/>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="activity-icon green">
                                            <i class="fa fa-map-marker"></i>
                                        </div>
                                        <div class="activity-desk">
                                            <h2 class="green">Yesterday</h2>
                                            <p>another event example with <a href="#" class="blue">a link</a>, <a href="#" class="terques">another link</a>, and <a href="#" class="terques">some other link</a> regarding something.</p>
                                        </div>

                                        <div class="activity-icon yellow">
                                            <i class="fa fa-user-md"></i>
                                        </div>
                                        <div class="activity-desk">
                                            <h2 class="yellow">12 december 2015</h2>
                                            <p>Some event that happened a while ago.</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="prf-box">
                                        <h3 class="prf-border-head">work in progress</h3>
                                        <div class=" wk-progress">
                                            <div class="col-md-5">Item 1</div>
                                            <div class="col-md-5">
                                                <div class="progress  ">
                                                    <div style="width: 70%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-danger">
                                                        <span class="sr-only">70% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">70%</div>
                                        </div>
                                        <div class=" wk-progress">
                                            <div class="col-md-5">Item 2</div>
                                            <div class="col-md-5">
                                                <div class="progress ">
                                                    <div style="width: 57%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">
                                                        <span class="sr-only">57% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">57%</div>
                                        </div>
                                        <div class=" wk-progress">
                                            <div class="col-md-5">Item 3</div>
                                            <div class="col-md-5">
                                                <div class="progress ">
                                                    <div style="width: 20%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-info">
                                                        <span class="sr-only">20% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">20%</div>
                                        </div>
                                        <div class=" wk-progress">
                                            <div class="col-md-5">Item 4</div>
                                            <div class="col-md-5">
                                                <div class="progress ">
                                                    <div style="width: 30%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-warning">
                                                        <span class="sr-only">30% Complete (success)</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">30%</div>
                                        </div>
                                    </div>
                                    <div class="prf-box">
                                        <h3 class="prf-border-head">performance status</h3>
                                        <div class=" wk-progress pf-status">
                                            <div class="col-md-8 col-xs-8">Metric 1</div>
                                            <div class="col-md-4 col-xs-4">
                                                <strong>23,545</strong>
                                            </div>
                                        </div>
                                        <div class=" wk-progress pf-status">
                                            <div class="col-md-8 col-xs-8">Metric 2</div>
                                            <div class="col-md-4 col-xs-4">
                                                <strong>235</strong>
                                            </div>
                                        </div>
                                        <div class=" wk-progress pf-status">
                                            <div class="col-md-8 col-xs-8">Metric 3</div>
                                            <div class="col-md-4 col-xs-4">
                                                <strong>235,452,344</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="activity-history" class="tab-pane ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="timeline-messages">
                                        <h3>Take a Tour</h3>
                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        13 January 2013
                                                    </div>
                                                    <div class="second bg-terques ">
                                                        Join as Product Asst. Manager
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->

                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        10 February 2012
                                                    </div>
                                                    <div class="second bg-red">
                                                        Completed Provition period and Appointed as a permanent Employee
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->

                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        2 January 2011
                                                    </div>
                                                    <div class="second bg-purple">
                                                        Selected Employee of the Month
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->

                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        4 March 2010
                                                    </div>
                                                    <div class="second bg-green">
                                                        Got Promotion and become area manager of California
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        3 April 2009
                                                    </div>
                                                    <div class="second bg-yellow">
                                                        Selected the Best Employee of the Year 2013 and was awarded
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->

                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        23 May 2008
                                                    </div>
                                                    <div class="second bg-terques">
                                                        Got Promotion and become Product Manager and was transper from Branch to Head Office. Lorem ipsum dolor sit amet
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        14 June 2007
                                                    </div>
                                                    <div class="second bg-blue">
                                                        Height Sales scored and break all of the previous sales record ever in the company. Awarded
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                        <!-- Comment -->
                                        <div class="msg-time-chat">
                                            <div class="message-body msg-in">
                                                <span class="arrow"></span>
                                                <div class="text">
                                                    <div class="first">
                                                        1 January 2006
                                                    </div>
                                                    <div class="second bg-green">
                                                        Take 15 days leave for his wedding and Honeymoon & Christmas
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                    </div>
                                </div>
                            </div>
                        </div>
                         --}}
                        <div id="settings" class="tab-pane active">
                            <div class="position-center">
                                <div class="prf-contacts sttng">
                                    <h2>  Personal Information</h2>
                                </div>
                                {!!
                                    Form::model(Auth::user(), [
                                        'class' => 'form-horizontal bucket-form ajax-form',
                                        'method' => 'PUT',
                                        'data-target' => '#record-detail',
                                        'url' => '/user-profile'
                                    ])
                                !!}
                                    {!! Form::hidden('profile_type', 'default') !!}
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label"> Avatar</label>
                                        <div class="col-lg-6">
                                            <input type="file" id="exampleInputFile" class="file-pos">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('first_name', 'First Name', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('last_name', 'Last Name', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('phone', 'Phone Number', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email Address', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('last_name', 'Change Password', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => '', 'autocomplete' => 'off']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('last_name', 'Confirm Change Password', ['class' => 'col-lg-3 control-label']) !!}
                                        <div class="col-lg-6">
                                            {!! Form::password('confirm_password', ['class' => 'form-control', 'placeholder' => '', 'autocomplete' => 'off']) !!}
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save</button>
                                {!! Form::close() !!}
{{--                                 <div class="prf-contacts sttng">
                                    <h2> socail networks</h2>
                                </div>
                                <form role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Facebook</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="fb-name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Twitter</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="twitter" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Google plus</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="g-plus" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Flicr</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="flicr" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Youtube</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="youtube" class="form-control">
                                        </div>
                                    </div>

                                </form>
                                <div class="prf-contacts sttng">
                                    <h2>Contact</h2>
                                </div>
                                <form role="form" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Address 1</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="addr1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Address 2</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="addr2" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Phone</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="phone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Cell</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="cell" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Email</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Skype</label>
                                        <div class="col-lg-6">
                                            <input type="text" placeholder="" id="skype" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-10">
                                            <button class="btn btn-primary" type="submit">Save</button>
                                            <button class="btn btn-default" type="button">Cancel</button>
                                        </div>
                                    </div>

                                </form> --}}
                            </div>

                        </div>
                        @foreach($data as $profile)
                        <div id="{{$profile->profile_key}}" class="tab-pane ">
                            <div class="position-center">
                                <div class="prf-contacts sttng">
                                    <h2>{{$profile->profile_name}} Settings</h2>
                                </div>
                                {!!
                                    Form::model(Auth::user()->{$profile->profile_key}, [
                                        'class' => 'form-horizontal bucket-form ajax-form',
                                        'method' => 'PUT',
                                        'data-target' => '#record-detail',
                                        'url' => '/user-profile'
                                    ])
                                !!}
                                    {!! Form::hidden('profile_type', $profile->profile_key) !!}
                                    @include('ui::partials.form_fields', ['fields' => $profile->form_fields])
                                {!! Form::close() !!}
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
