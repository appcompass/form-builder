<section class="panel">
    <div class="panel-body">
        <h5>{{ $meta->sub_section_name or $meta->show->sub_section_name }}</h5>
        <ul class="nav nav-pills nav-stacked mail-nav">
            @foreach($nav as $subnav_content)

            <li>
                <a href="{{ $meta->base_url.$subnav_content->props->link->href }}" data-click="{{ $meta->base_url.$subnav_content->props->link->href }}" {!! inlineAttrs($subnav_content->props, 'link') !!} >
                    <i class="fa fa-{{ $subnav_content->props->icon or 'list' }}"> </i>
                    <span>{{ $subnav_content->label }}</span>
                </a>
            </li>

            @endforeach

        </ul>
    </div>
</section>
