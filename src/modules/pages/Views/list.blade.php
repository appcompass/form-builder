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
            <th>URL</th>
            <th>Created</th>
            <th>Published</th>
          </tr>
          </thead>
          <tbody>
          @foreach($website->pages as $page)
          <tr>
            <td><a href="#" data-click="/cp/websites/{{ $website->id }}/pages/{{ $page->id }}" data-target="#main-content">{{ $page->title }}</a></td>
            {{-- <td><a href="{{ $record->site_url }}" target="_blank">{{ $record->site_url }}</a></td> --}}
            {{-- <td>{{ $record->created_at }}</td> --}}
            {{-- <td>{{ $record->published_at }}</td> --}}
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </div>
</div>