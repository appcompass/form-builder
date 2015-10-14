	    <link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-colorpicker/css/colorpicker.css" />
		<form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/websites/{{ $record->id }}/settings" data-target="#website-detail">
			<section class="panel">
				<header class="panel-heading">
					Website Default Header/Meta Data
				</header>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Default Title</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="settings[head][title]" placeholder="Best Website ever!" value="{{ $record->settings()->head->title or '' }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Default Description</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="settings[head][description]" placeholder="Best Website ever description goes here!" value="{{ $record->settings()->head->description or '' }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Default Keywords</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="settings[head][keywords]" placeholder="cool, website, design, stuff">{{ $record->settings()->head->keywords or '' }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Custom Header HTML</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="settings[head][custom_html]" placeholder="{{ '<script> var javascript_accepted = true; </script>' }}">{{ $record->settings()->head->custom_html or '' }}</textarea>
							<span class="help-block">This code is inserted on every page globally right before the closing {{ '</head>' }} tag.</span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">robot.txt contents</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="settings[robot_txt]">{{ $record->settings()->robot_txt or '' }}</textarea>
						</div>
					</div>
				</div>
			</section>
			<section class="panel">
				<header class="panel-heading">
					Website Theme
				</header>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">Website Logo</label>
						<div class="col-sm-6">
							<div>{{ $record->settings()->theme->logo->file or '' }}</div>
							<input type="file" name="settings[theme][logo][file]">
							<input type="hidden" name="settings[theme][logo][path]" value="/images/">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Primary Color</label>
						<div class="col-sm-6">
							<input type="text" class="colorpicker-default form-control" name="settings[theme][primary_color]" value="{{ $record->settings()->theme->primary_color or '' }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Secondary Color</label>
						<div class="col-sm-6">
							<input type="text" class="colorpicker-default form-control" name="settings[theme][secondary_color]" value="{{ $record->settings()->theme->secondary_color or '' }}">
						</div>
					</div>
 					<button type="submit" class="btn btn-info">Save</button>
				</div>
			</section>
		</form>
		<script type="text/javascript" src="/assets/ui/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script type="text/javascript">
			$('.colorpicker-default').colorpicker({
				format: 'hex'
			});
		</script>