		<section class="panel">
			<header class="panel-heading">
				Connection Information
			</header>
			<div class="panel-body">
				<form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/websites/{{ $record->id }}/connection" data-target="#website-detail">
					<div class="form-group">
						<label class="col-sm-3 control-label">Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="site_name" placeholder="Website.com" value="{{ $record->site_name }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">URL</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="site_url" placeholder="https://www.website.com" value="{{ $record->site_url }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">From Email Address</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="from_email" placeholder="website@website.com" value="{{ $record->from_email }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">From Email Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="from_name" placeholder="Website Name" value="{{ $record->from_name }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">A Managed Website</label>
						<div class="col-sm-6">
							<input type="checkbox" name="managed" value="true" @if($record->managed) checked="checked"  @endif >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">SSH Host</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="ssh_host" placeholder="SSH Host" value="{{ $record->ssh_host }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">SSH Username</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="ssh_username" placeholder="SSH Username" value="{{ $record->ssh_username }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">SSH Password</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="ssh_password" placeholder="SSH Password" value="{{ $record->ssh_password }}">
							<span class="help-block">Must use either SSH Password or SSH Key below (key is preferable).</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">SSH Key</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="ssh_key" placeholder="SSH Key">{{ $record->ssh_key }}</textarea>
							<span class="help-block">Must use either SSH Key or SSH Password above (key is preferable).</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">SSH Key Phrase</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="ssh_keyphrase" placeholder="SSH Key Phrase" value="{{ $record->ssh_keyphrase }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Website Document Root</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="ssh_root" placeholder="/path/to/document/root" value="{{ $record->ssh_root }}">
						</div>
					</div>

{{-- 					<div class="form-group has-error">
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