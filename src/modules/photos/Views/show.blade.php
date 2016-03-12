<div class="modal-backdrop fade in" style="height: 100%"></div>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title">Edit Media Gallery</h4>
        </div>

        <div class="modal-body row">

            <div class="col-md-5 img-modal">
                <img src="{{ $photo->path }}" alt="">
                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit Image</a>
                <a href="#" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> View Full Size</a>

                <p class="mtop10"><strong>File Name:</strong> {{ $photo->name }}</p>
                <p><strong>File Type:</strong> jpg</p>
                <p><strong>Resolution:</strong> 300x200</p>
                <p><strong>Uploaded By:</strong> <a href="#">{{ $photo->user->full_name }}</a></p>
            </div>

            <div class="col-md-7">
                {!!
                    Form::model($photo, [
                        'class' => 'form-horizontal bucket-form ajax-form modal-form',
                        'method' => 'PUT',
                        'data-target' => '#main-content-out',
                        'url' => '/photos/'.$photo->id
                    ])
                !!}

                    <div class="form-group">
                        <label> Name</label>
                        <input id="name" value="{{ $photo->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label> Label</label>
                        <input id="title" value="{{ $photo->label }}" class="form-control">
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label> Status</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2" checked="checked">
                                     Pending
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                     Approved
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label> Image Type</label>
                            <select>
                                <option>Kitchen</option>
                                <option>Garage</option>
                                <option>Outside</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Description</label>
                        <textarea rows="2" class="form-control">{{ $photo->desc or '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label> Link URL</label>
                        <input id="link" value="{{ $photo->path }}" class="form-control">
                    </div>
                    <div class="pull-right">
                        {!! Form::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Changes</button>
                    </div>

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
