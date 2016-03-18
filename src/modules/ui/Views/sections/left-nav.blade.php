<!-- sidebar menu start-->
<div class="leftside-navigation">
    <ul class="sidebar-menu" id="nav-accordion">
        @foreach($nav as $item)
            <li class="collapsable" @if(!empty($item->children)) sub-menu @endif">
                <a {!! inlineAttrs($item->props, 'link') !!} >
                    <i class="fa fa-{{ $item->props->icon or 'list' }}"></i> {{ $item->label }}
                </a>
                @if(!empty($item->children))
                    <ul class="sub" v-bind:class="{'toggled': isHidden}">

                        @foreach($item->children as $sub_item)
                            <li>
                                <a {!! inlineAttrs($sub_item->props, 'link') !!}>
                                    <i class="fa fa-{{ $sub_item->props->icon or "list" }}"> </i>
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

<script>
    (function() {
        $('.collapsable').on('click', function() {
            $(this).find('ul').first().toggleClass('hidden')
        })
    })()
</script>
