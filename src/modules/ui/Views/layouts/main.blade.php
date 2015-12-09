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

			<div class="nav notify-row" id="top_menu" data-load="/left-alerts">
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
							<img alt="" src="" data-load="/user-avatar/29" data-load-self="src">
							<span class="username" data-load="/user-full-name"></span>
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
			<div id="sidebar" class="nav-collapse" data-load="/left-nav">
			</div>
		</aside>
		<!--sidebar end-->
			<!--main content start-->
			<section id="main-content">
                <section class="wrapper">
                <!-- page start-->
                    <div class="row">
                        <div class="col-sm-12" id="main-content-out">
                        </div>
                    </div>
                </section>
			</section>
			<!--main content end-->
		<!--right sidebar start-->
		<div class="right-sidebar">
			<div class="search-row">
				<input type="text" placeholder="Search" class="form-control">
			</div>
			<div class="right-stat-bar" data-load="/notification-center">
			</div>
		</div>
		<!--right sidebar end-->

	</section>

  <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title"><span></span></h4>
              </div>
              <div class="modal-body message">

              </div>
              <div class="modal-footer">
                  <button class="btn btn-primary" type="button" data-dismiss="modal"> Ok</button>
              </div>
          </div>
      </div>
  </div>

  {{-- Generic modal injection point --}}
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modal-body">
      </div>
    </div>
  </div>

@include("ui::common.footer")