@include("ui::common.header", ['bodyClass' => 'login-body'])

	<div class="container">

		<form class="form-signin" method="POST" action="/login">
			{!! csrf_field() !!}
			<h2 class="form-signin-heading">sign in now</h2>
			<div class="login-wrap">

				<div class="user-login-info">
					{{ $errors->first('email') }}
					<input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>
					{{ $errors->first('password') }}
					<input type="password" class="form-control" name="password" placeholder="Password">
				</div>
				<label class="checkbox">
					<input type="checkbox" name="remember"> Remember me
					<span class="pull-right">
						<a data-toggle="modal" href="#myModal"> Forgot Password?</a>

					</span>
				</label>
				<button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

{{--
 				<div class="registration">
					Don't have an account yet?
					<a class="" href="registration.html">
						Create an account
					</a>
				</div>
 --}}
			</div>
		</form>

		<!-- Modal -->
		<form class="form-signin" method="POST" action="/forgot-password">
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Forgot Password ?</h4>
						</div>
						<div class="modal-body">
							<p>Enter your e-mail address below to reset your password.</p>
							<input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
						</div>
						<div class="modal-footer">
							<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
							<button class="btn btn-success" type="button">Submit</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- modal -->

	</div>
@include("ui::common.footer", ['nolock' => true])