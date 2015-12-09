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

          <a
            href="#modal-edit"
            class="btn btn-xs edit-subnav"
            title="Edit menu options"
            data-action="modal-edit"
            data-toggle="modal"
            data-navmenu="{{ $item->name }}"
            data-inject-area="#modal-body"
            data-click="/websites/{{ $website->id }}/navigation/{{ $item->id }}/edit"
          >
            <i class="fa fa-cog" > </i>
          </a>

          <a
            href="#modal-edit"
            class="btn btn-xs add-subnav"
            title="Add subnav"
            data-action="modal-edit"
            data-toggle="modal"
            data-navmenu="{{ $item->name }}"
            data-inject-area="#modal-body"
            data-click="/websites/{{ $website->id }}/navigation/create?parent={{ $item->name }}"
          >
            <i class="fa fa-plus"> </i>
          </a>

      @endif
        <a
          href="/websites/{{ $website->id }}/navigation/{{ $item->pivot->id }}"
          class="delete-icon pull-right"
        >
          <i class="fa fa-trash-o"> </i>
        </a>

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