  <!-- page start-->
    <div class="row">
    <div class="col-sm-12">
      <section class="panel">
        <header class="panel-heading">
          Manage Gallery Photos
        </header>
        <div class="panel-body">
          <table class="table  table-hover general-table">
            <thead>
            <tr>
              <th></th>
              <th>Name</th>
              <th>Status</th>
              <th>Storage</th>
              <th>Created</th>
              <th>Updated</th>
              <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @foreach($gallery as $photo)
              <tr>
                <td><a href="{{ $photo->path }}" data-lity><img src="{{$photo->path}}" height="20" alt=""></a></td>
                <td>{{ substr($photo->path, 0, 40).'...' }}</td>
                <td>{{ $photo->status }}</td>
                <td>{{ $photo->storage }}</td>
                <td>{{ $photo->created_at }}</td>
                <td>{{ $photo->updated_at }}</td>
                <td>{{ $photo->getOption('photo-of', 'label') }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </section>
    </div>
