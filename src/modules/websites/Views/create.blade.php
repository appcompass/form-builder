        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-sm-3">
                    <section class="panel">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked mail-nav">
                                <li class="active"><a href="#"> <i class="fa fa-list"></i> Website Connection </a></li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-sm-9">
                    <section class="panel">
                        <header class="panel-heading">
                            Connection Information
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/websites" data-target="#main-content">
								{{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="site_name" placeholder="Website.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">URL</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="site_url" placeholder="https://www.website.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">From Email Address</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[from_email]" placeholder="website@website.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">From Email Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[from_name]" placeholder="Website Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">A Managed Website</label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" name="config[managed]">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SSH Host</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[ssh_host]" placeholder="SSH Host">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SSH Username</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[ssh_username]" placeholder="SSH Username">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SSH Password</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[ssh_password]" placeholder="SSH Password">
                                        <span class="help-block">Must use either SSH Password or SSH Key below (key is preferable).</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SSH Key</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="config[ssh_key]" placeholder="SSH Key">{{ $record->config->ssh_key or '' }}</textarea>
                                        <span class="help-block">Must use either SSH Key or SSH Password above (key is preferable).</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">SSH Key Phrase</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[ssh_keyphrase]" placeholder="SSH Key Phrase">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Website Document Root</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="config[ssh_root]" placeholder="/path/to/document/root">
                                    </div>
                                </div>

                    {{--                    <div class="form-group has-error">
                                    <label class="col-sm-3 control-label col-lg-3" for="inputError">Input with error</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="inputError">
                                    </div>
                                </div>
                    --}}
                                    <button type="submit" class="btn btn-info">Create</button>
                                </form>
                        </div>
                    </section>
                </div>
            </div>

        <!-- page end-->
        </section>