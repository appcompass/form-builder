<section class="panel">
    <div class="panel-body">
        <h5>{{ $meta->show->sub_section_name }}</h5>
        <ul class="nav nav-pills nav-stacked mail-nav">

            @foreach($nav->items as $subnav_name => $subnav_content)

            <li>
                <a {!! inlineAttrs($subnav_content->props, 'link') !!}>
                    <i class="fa {{ $subnav_content['icon'] }}"></i>
                    <span>{{ $subnav_content['label'] }}</span>
                </a>
            </li>

            @endforeach

        </ul>
    </div>
</section>