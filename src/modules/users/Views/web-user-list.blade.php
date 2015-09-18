		<section class="wrapper">
		<!-- page start-->
			<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Manage Web Users
					</header>
					<div class="panel-body">
						<table class="table  table-hover general-table">
							<thead>
							<tr>
								<th>Name</th>
								<th class="hidden-phone">Phone</th>
								<th>Created</th>
								<th>Registered On</th>
								<th>Saved Properties</th>
							</tr>
							</thead>
							<tbody>
							@foreach($data as $user)
							<tr>
								<td><a href="mailto:{{ $user->email }}">{{ $user->first_name.' '.$user->last_name }}</a></td>
								<td class="hidden-phone">{{ $user->phone }}</td>
								<td>{{ $user->created_at }}</td>
								<td><span class="label label-info label-mini">{{ $user->site_registered_on }}</span></td>
								<td>{{ $user->saved_properties }}</td>
							</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>