<section class="panel">
    <div class="panel-body">
        <h5>{{ $meta->show->sub_section_name }}</h5>
        <ul class="nav nav-pills nav-stacked mail-nav">

            @foreach($nav->items as $i => $subnav_content)

            <li>
                <a href="#{{ $meta->base_url.'/'.$subnav_content['url'] }}" data-click="{{ $meta->base_url.'/'.$subnav_content['url'] }}" {!! inlineAttrs($subnav_content->props, 'link') !!} >
                    <i class="fa {{ $subnav_content['icon'] }}"></i>
                    <span>{{ $subnav_content['label'] }}</span>
                </a>
            </li>

            @endforeach

        </ul>
    </div>
</section>