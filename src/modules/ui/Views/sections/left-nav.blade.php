<!-- sidebar menu start-->
<div class="leftside-navigation">
	<ul class="sidebar-menu" id="nav-accordion">

		@foreach($nav->items as $item)

			<li @if($item->has_content) class="sub-menu" @endif>
				<a {!! inlineAttrs($item->props, 'link') !!}><i class="fa fa-{{ $item->props['icon'] or 'list' }}"></i>{{ $item->label }}</a>

				@if ($item->has_content)
					<ul class="sub">

						@foreach($nav->children->find($item->navigatable_id)->items as $sub_item)
							<li>
								<a {!! inlineAttrs($sub_item->props, 'link') !!}><i class="fa fa-{{ $sub_item->props['icon'] or "list" }}"></i>{{ $sub_item->label }}</a>
							</li>
						@endforeach

					</ul>
				@endif

			</li>

		@endforeach

	</ul>
</div>
{{-- <script class="include" type="text/javascript" src="/assets/ui/js/jquery.dcjqaccordion.2.7.js"></script> --}}
{{-- <script src="/assets/ui/js/jquery.scrollTo.min.js"></script> --}}
{{-- <script src="/assets/ui/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script> --}}
{{-- <script src="/assets/ui/js/jquery.nicescroll.js"></script> --}}
