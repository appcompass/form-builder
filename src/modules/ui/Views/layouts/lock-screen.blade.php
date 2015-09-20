@include("ui::common.header", ['bodyClass' => 'lock-screen', 'bodyOnLoad' => 'startTime()'])
	<div class="lock-wrapper">

		<div id="time"></div>


		<div class="lock-box text-center">
			<div class="lock-name">{{ $user_fullname }}</div>
			<img alt="" src="{{ $user_avatar }}">
			<div class="lock-pwd">
				<form role="form" class="form-inline" method="POST" action="/login">
					{!! csrf_field() !!}
					<div class="form-group">
						<input type="hidden" name="email" value="{{ $user_email }}">
						<input type="password" type="password" placeholder="Password" id="exampleInputPassword2" class="form-control lock-input">
						<button class="btn btn-lock" type="submit">
							<i class="fa fa-arrow-right"></i>
						</button>
					</div>
				</form>
			</div>

		</div>
	</div>
	<script>
		function startTime()
		{
			var today=new Date();
			var h=today.getHours();
			var m=today.getMinutes();
			var s=today.getSeconds();
			// add a zero in front of numbers<10
			m=checkTime(m);
			s=checkTime(s);
			document.getElementById('time').innerHTML=h+":"+m+":"+s;
			t=setTimeout(function(){startTime()},500);
		}

		function checkTime(i)
		{
			if (i<10)
			{
				i="0" + i;
			}
			return i;
		}
	</script>
@include("ui::common.footer", ['nolock' => true])