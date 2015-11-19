<li
  id="menuItem_{{ $item->id }}"
  data-id="menuItem_{{ $item->id }}"
  data-has-content="{{ $item->has_content }}"
>
  <i class="handle fa fa-arrows"> </i>
  <div>{{ $item->label }}</div>

  @if ($item->has_content)
    <ol>
      @foreach($item->navigatable->items as $sub_item)
        @include('navigation::navmenu_section', ['item' => $sub_item, 'navmenu' => $navmenu])
      @endforeach
    </ol>
  @endif

</li>