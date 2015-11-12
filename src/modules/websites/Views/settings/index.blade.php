<link rel="stylesheet" type="text/css" href="/assets/ui/js/bootstrap-colorpicker/css/colorpicker.css" />

<section class="panel">

	<header class="panel-heading">
		Website Default Header/Meta Data
	</header>

	<div class="panel-body">

			{!! Form::model($settings, [
						'url' => "/cp/websites/{{ $website->id }}/settings",
						'data-target' => '#record-detail',
						'class' => 'form-horizontal bucket-form ajax-form',
						'method' => 'PUT',
						'files' => true,
					])
			!!}

			<div class="form-group">
				{!! Form::label('title', 'Default title', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::text("default_title", null, ['class' => 'form-control col-sm-6']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('title', 'Default Description', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::text("default_description", null, ['class' => 'form-control col-sm-6']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('title', 'Default Keywords', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::text("default_keywords", null, ['class' => 'form-control col-sm-6']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('custom_html_header', 'Custom Header HTML', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::textarea("custom_html_header", null, ['class' => 'form-control col-sm-6']) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('robots_txt', 'robots.txt Content', ['class' => 'col-sm-3 control-label']) !!}
				<div class="col-sm-6">
					{!! Form::textarea("robots_txt", null, ['class' => 'form-control col-sm-6']) !!}
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
			{!! Form::label('logo', 'Website Logo', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::file('logo') !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('color_primary', 'Primary Color', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::text('color_primary', ['class' => 'colorpicker-default form-control']) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('color_secondary', 'Secondary Color', ['class' => 'col-sm-3 control-label']) !!}
			<div class="col-sm-6">
				{!! Form::text('color_secondary', ['class' => 'colorpicker-default form-control']) !!}
			</div>
		</div>

		{!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
		{!! Form::close() !!}

	</div>

</section>

<script type="text/javascript" src="/assets/ui/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript">
	$('.colorpicker-default').colorpicker({
		format: 'hex'
	});
</script>