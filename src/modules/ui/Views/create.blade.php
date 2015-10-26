        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-sm-3">
                    <section class="panel">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked mail-nav">
                                <li class="active"><a href="#"> <i class="fa fa-list"></i> Gallery Info </a></li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-sm-9">
                    <section class="panel">
                        <header class="panel-heading">
                            Gallery Information
                        </header>
                        <div class="panel-body">
                            <form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/galleries" data-target="#main-content">
								{{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" placeholder="Gallery Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="description" placeholder="A discription of this gallery goes here"></textarea>
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