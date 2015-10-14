		<!-- sidebar menu start-->
		<div class="leftside-navigation">
			<ul class="sidebar-menu" id="nav-accordion">
				@foreach($nav as $nav_item)
				<li @if($nav_item['sub_nav']) class="sub-menu" @endif>
					<a
					@foreach($nav_item['attributes'] as $attribute => $value)
						{{ $attribute }}="{{ $value }}"
					@endforeach
					>
						@if($nav_item['icon']) <i class="fa {{ $nav_item['icon'] }}"></i> @endif
						<span>{{ $nav_item['label'] }}</span>
					</a>
					@if($nav_item['sub_nav'])
						<ul class="sub">
							@foreach($nav_item['sub_nav'] as $sub_nav)
								<li>
									<a
									@foreach($sub_nav['attributes'] as $attribute => $value)
										{{ $attribute }}="{{ $value }}"
									@endforeach
									>
										<span>{{ $sub_nav['label'] }}</span>
									</a>
								</li>
							@endforeach
						</ul>
					@endif
				</li>
				@endforeach
			</ul>
		</div>
		<!-- sidebar menu end-->

		<script class="include" type="text/javascript" src="/assets/ui/js/jquery.dcjqaccordion.2.7.js"></script>
		<script src="/assets/ui/js/jquery.scrollTo.min.js"></script>
		<script src="/assets/ui/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
		<script src="/assets/ui/js/jquery.nicescroll.js"></script>
