<li
  id="menuItem_{{ $item->id }}"
  data-id="menuItem_{{ $item->id }}"
  data-has-content="{{ $item->has_content }}"
>
  <div>
    <i class="handle fa fa-arrows"> </i>
      {{ $item->label }}
      <div class="tools pull-right">
      @if($item->has_content)
          <a class="no-link btn btn-xs" title="Edit menu options" data-toggle="modal" href="#myModal"> <i class="fa fa-cog" > </i> </a>
          <a href="#!" title="Add subnav" class="no-link btn btn-xs"> <i class="fa fa-plus" > </i></a>
      @endif
        <a href="/websites/{{ $website->id }}/navigation/{{ $item->pivot->id }}" class="no-link delete-icon"> <i class="fa fa-trash-o"> </i> </a>
      </div>
  </div>

  @if ($item->has_content)
    <ol>
      {{-- <a href="#!" title="Add Subnav Container" class="btn btn-default btn-xs add_subnav pull-right" data-parent-nav=""><i class="fa fa-plus"> </i> </a> --}}
      @foreach($item->navigatable->items as $sub_item)
        @include('navigation::navmenu_section', ['item' => $sub_item, 'navmenu' => $navmenu,  'website' => $website])
      @endforeach
    </ol>
  @endif

</li>