<section class="panel">
    <div class="panel-body">
        <h5>{{ $meta->show->sub_section_name }}</h5>
        <ul class="nav nav-pills nav-stacked mail-nav">

            @foreach($nav->items as $i => $subnav_content)

            <li>
                <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$subnav_content['url'] }}" {!! inlineAttrs($subnav_content->props, 'link') !!} @if($i === 0) data-trigger @endif >
                    <i class="fa {{ $subnav_content['icon'] }}"></i>
                    <span>{{ $subnav_content['label'] }}</span>
                </a>
            </li>

            @endforeach

        </ul>
    </div>
</section>