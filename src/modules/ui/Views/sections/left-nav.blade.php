<!-- sidebar menu start-->
<div class="leftside-navigation">
	<ul class="sidebar-menu" id="nav-accordion">

	@foreach($nav->navitems as $item)
		<li @if($nav->hasChildren($item->linked_id)) class="sub-menu" @endif>
			<a href="{{ $item->url }}" {!! inlineAttrs($item->props, 'link') !!}>
				<i class="fa fa-{{ $item->navitem->props['icon'] or 'list' }}"></i>{{ $item->label }}
			</a>

			@if ($nav->hasChildren($item->linked_id))
				<ul class="sub">

					@foreach($nav->children->find($item->linked_id)->navitems as $sub_item)
						<li>
							<a href="{{ $sub_item->url }}" {!! inlineAttrs($sub_item->navitem->props, 'link') !!}>
								<i class="fa fa-{{ $sub_item->navitem->props['icon'] or "list" }}"> </i>
								{{ $sub_item->label }}
							</a>
						</li>
					@endforeach

				</ul>
			@endif

		</li>
	@endforeach

	</ul>
</div>