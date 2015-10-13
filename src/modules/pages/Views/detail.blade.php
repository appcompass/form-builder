    <section class="panel">

      <header class="panel-heading">
        Connection Information
      </header>
      <div class="panel-body">
        <form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/websites" data-target="#website-detail">
          <div class="form-group">
            <label class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control" name="site_name" placeholder="Page Name" value="{{ $page->title }}">
            </div>
          </div>

{{--          <div class="form-group has-error">
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