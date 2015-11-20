<li
  id="menuItem_{{ $item->id }}"
  data-id="menuItem_{{ $item->id }}"
  data-has-content="{{ $item->has_content }}"
>
  <i class="handle fa fa-arrows"> </i>
  <div>
    {!! Form::open([
      'url' => "/websites/$website->id/navigation/$item->id",
      'method' => 'PUT',
      'class' => 'just-ajax-save'
    ]) !!}
      <input type="text" name="label" value="{{ $item->label }}">
      <button type="submit"><i class="fa fa-save" > </i></button>
    {!! Form::close() !!}
  </div>

  @if ($item->has_content)
    <ol>
      @foreach($item->navigatable->items as $sub_item)
        @include('navigation::navmenu_section', ['item' => $sub_item, 'navmenu' => $navmenu,  'website' => $website])
      @endforeach
    </ol>
  @endif

</li>