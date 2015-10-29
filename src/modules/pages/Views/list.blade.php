<section class="wrapper">
<!-- page start-->
  <div class="row">
  <div class="col-sm-12">
    <section class="panel">
      <header class="panel-heading">
        Manage Pages
      </header>
      <div class="panel-body">
        <table class="table  table-hover general-table">
          <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Created</th>
            <th>Published</th>
          </tr>
          </thead>
          <tbody>

          @foreach($website->pages as $page)
            <tr>
              <td><a href="#" data-click="/cp/pages/{{ $page->id }}" data-target="#record-detail">{{ $page->title }}</a></td>
              <td><a href="{{ $page->fullUrl }}" target="_blank">{{ $page->slug }}</a></td>
              <td>{{ $page->created_at }}</td>
              <td>{{ $page->published_at }}</td>
            </tr>
          @endforeach

          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>