		<section class="wrapper">
		<!-- page start-->
			<div class="row">
			<div class="col-sm-12">
				<section class="panel">
					<header class="panel-heading">
						Manage Agents
						<span class="tools pull-right">
							<a href="javascript:;" class="fa fa-chevron-down"></a>
							<a href="javascript:;" class="fa fa-cog"></a>
							<a href="javascript:;" class="fa fa-times"></a>
						 </span>
					</header>
					<div class="panel-body">
						<table class="table  table-hover general-table">
							<thead>
							<tr>
								<th>Name</th>
								<th class="hidden-phone">Phone</th>
								<th>Created</th>
								<th>Agent Status</th>
								<th>Class Progress</th>
							</tr>
							</thead>
							<tbody>
							@foreach($data as $user)
							<tr>
								<td><a href="mailto:{{ $user->email }}">{{ $user->first_name.' '.$user->last_name }}</a></td>
								<td class="hidden-phone">{{ $user->phone }}</td>
								<td>{{ $user->created_at }}</td>
								<td><span class="label label-info label-mini">{{ $user->agent_status }}</span></td>
								<td>
									<div class="progress progress-striped progress-xs">
										<div style="width: {{ $user->class_progress }}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="{{ $user->class_progress }}" role="progressbar" class="progress-bar progress-bar-{{ $user->class_progress_status }}">
											<span class="sr-only">{{ $user->class_progress }}% Complete ({{ $user->class_progress_status }})</span>
										</div>
									</div>
								</td>
							</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>