		<section class="wrapper">
		<!-- page start-->
			<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Manage Websites
					</header>
					<div class="panel-body">
                            <div class="clearfix">
                                <div class="btn-group">
                                    <a id="editable-sample_new" class="btn btn-primary" href="#" data-click="/cp/websites/create" data-target="#main-content">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="space15"></div>
						<table class="table  table-hover general-table">
							<thead>
							<tr>
								<th>Name</th>
								<th>URL</th>
								<th>Created</th>
								<th>Updated</th>
							</tr>
							</thead>
							<tbody>
							@foreach($records as $record)
							<tr>
								<td><a href="#" data-click="/cp/websites/{{ $record->id }}" data-target="#main-content">{{ $record->site_name }}</a></td>
								<td><a href="{{ $record->site_url }}" target="_blank">{{ $record->site_url }}</a></td>
								<td>{{ $record->created_at }}</td>
								<td>{{ $record->updated_at }}</td>
							</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>