@include("ui::common.header")

	<section id="container">
		<!--header start-->
		<header class="header fixed-top clearfix">
			<!--logo start-->
			<div class="brand">

				<a href="index.html" class="logo">
					Plus 3 CMS {{-- logo image goes here: <img src="/path/to/logo.png" alt=""> --}}
				</a>
				<div class="sidebar-toggle-box">
					<div class="fa fa-bars"></div>
				</div>
			</div>
			<!--logo end-->

			<div class="nav notify-row" id="top_menu" data-load="/cp/left-alerts">
			</div>
			<div class="top-nav clearfix">
				<!--search & user info start-->
				<ul class="nav pull-right top-menu">
					<li>
						<input type="text" class="form-control search" placeholder=" Search">
					</li>
					<!-- user login dropdown start-->
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">
							<img alt="" src="" data-load="/cp/user-avatar/29" data-load-self="src">
							<span class="username" data-load="/cp/user-full-name"></span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu extended logout" data-load="/user-nav">
						</ul>
					</li>
					<!-- user login dropdown end -->
					<li>
						<div class="toggle-right-box">
							<div class="fa fa-bars"></div>
						</div>
					</li>
				</ul>
				<!--search & user info end-->
			</div>
		</header>
		<!--header end-->
		<aside>
			<div id="sidebar" class="nav-collapse" data-load="/cp/left-nav">
			</div>
		</aside>
		<!--sidebar end-->
			<!--main content start-->
			<section id="main-content" data-load="/cp/dashboard">
			</section>
			<!--main content end-->
		<!--right sidebar start-->
		<div class="right-sidebar">
			<div class="search-row">
				<input type="text" placeholder="Search" class="form-control">
			</div>
			<div class="right-stat-bar" data-load="/cp/notification-center">
			</div>
		</div>
		<!--right sidebar end-->

	</section>
@include("ui::common.footer")