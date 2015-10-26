<section class="panel">
    <header class="panel-heading">
        Gallery Information
    </header>
    <div class="panel-body">
        <form class="form-horizontal bucket-form ajax-form" method="put" action="/cp/galleries/{{ $record->id }}" data-target="#record-detail">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="{{ $record->name }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Description</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="description" value="{{ $record->description }}">
                    <span class="help-block">Enter a description for the gallery.</span>
                </div>
            </div>
{{--                    <div class="form-group has-error">
                <label class="col-sm-3 control-label col-lg-3" for="inputError">Input with error</label>
                <div class="col-lg-6">
                    <input type="text" class="form-control" id="inputError">
                </div>
            </div>
--}}
                <button type="submit" class="btn btn-info">Save</button>
            </form>
    </div>
</section>

  <div class="col-lg-6">
    <h3>{{ $record->name }}</h3>
    <p><b>Created by: </b> {{ $record->user->full_name }}</p>
    <p>{{ $record->description }}</p>

    @if (isset($photos))
      @foreach($photos as $photo)
        <img src="{{ $photo->path }}" alt="" width="200" class="img-thumbnail">
      @endforeach
    @endif
  </div>

<div class="col-lg-6">
    @can('update', $record)
        <div class="well">
            <h3>Add Photos</h3>
            <form action="/cp/galleries/{{ $record->id }}/photos" method="POST" class="dropzone" id="bp-dropzone">
                {{ csrf_field() }}
            </form>
        </div>
    @endcan
</div>

<link href="/assets/galleries/css/dropzone.css" rel="stylesheet">
<script src="/assets/galleries/js/dropzone.js"></script>
<script>

    Dropzone.autoDiscover = false;

    $(function() {
        var dz = new Dropzone('#bp-dropzone');

        dz.on('queuecomplete', function(file) {
        // window.location.reload();
        })

    })

</script>