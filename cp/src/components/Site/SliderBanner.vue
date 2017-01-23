<template id="SliderBanner">
    <section class="home-banner">
        <div class="home-banner-header">
            <div class="home-banner-header-container">
                <h1 class="home-banner-heading">{{ title }}</h1>
            </div>
        </div>
        <template v-for="slide in slides">
            <div class="work-slideshow">
                <article class="work-slide">
                    <div class="work-slide-container">
                        <div class="work-slide-image"><img src="{{ slide.banner_image }}"></div>
                        <div class="work-slide-content">
                            <h2 class="work-slide-title">{{ slide.title }}</h2>
                            <div class="work-slide-desc">
                                {{ slide.description }}
                            </div>
                            <a href="{{ slide.link_href }}" class="work-slide-btn"><span class="icon-plus"></span> {{ slide.link_text }}</a>
                        </div>
                    </div>
                </article>
            </div>
        </template>
    </section>
</template>

<script>
    new Vue({
        el: '#SliderBanner',
        data: {
            title: 'Our Work'
            slides: [
                {
                    banner_image: '/assets/images/content/slide_atmgurus.png',
                    title: 'ATM Gurus',
                    description: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis tortor lobortis, ultrices risus ac.</p>',
                    link_text: 'See More',
                    link_href: '/somewhere'
                }, {
                    banner_image: '/assets/images/content/slide_atmgurus.png',
                    title: 'Some Other project',
                    description: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis tortor lobortis, ultrices risus ac.</p>',
                    link_text: 'See More',
                    link_href: '/somewhere-else'
                }
            ]
        }
    })
</script>


<!--             FormBuilder::new('SliderBanner', function ($fb) {
                // we need to figure out how to handle the 'type' field.
                // the fields internally are created in the order they appear in the builder.
                $fb->string('Title', 'title', ['required']);
                $fb->fieldset('Slides', 'slides', [], function ($slide) {
                    // not field type, sub section builder.
                    $slide->file('Banner Image', 'banner_image', Photo::class, ['required']);
                    $slide->string('Title', 'title', ['required']);
                    $slide->wysiwyg('Description', 'description', ['required']);
                    $slide->string('Link Text', 'link_text', ['required']);
                    $slide->link('Link Destination', 'link_href', ['required']);
                })->repeatable();
            })->setOwner($slider_banner); -->