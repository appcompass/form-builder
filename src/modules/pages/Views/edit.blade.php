    <section class="panel">

      <header class="panel-heading">
        Page Details
      </header>
      <div class="panel-body">
        <form class="form-horizontal bucket-form ajax-form" method="post" action="/websites" data-target="#record-detail">
          <div class="form-group">
            <label class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="site_name" placeholder="Page Name" value="{{ $page->name }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Title</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="site_name" placeholder="Page Title" value="{{ $page->title }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Description</label>
            <div class="col-sm-6">
              <textarea class="form-control" name="description" placeholder="Desciption">{{ $page->description or '' }}</textarea>
            </div>
          </div>
          @if(isset($templates))
            <div class="form-group">
              <label class="col-sm-3 control-label">Template</label>
              <div class="col-sm-6">
                <select name="template" id="" class="form-control m-bot15">
                  @foreach($templates as $template_id => $template_name)
                    <option value="{{ $template_id }}" @if ($template_id == $page->template->id) selected="selected" @endif>{{ $template_name }}</option>
                  @endforeach
                </select>
                {{-- <textarea class="form-control" name="description" placeholder="Desciption">{{ $page->description or '' }}</textarea> --}}
              </div>
            </div>
          @endif
          <button type="submit" class="btn btn-info">Save</button>
        </form>
      </div>
    </section>