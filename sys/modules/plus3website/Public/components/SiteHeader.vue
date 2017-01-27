<template>
    <header class="header">
        <div class="logo-wrap">
            <nuxt-link to="/" class="logo"><span class="visually-hidden">Plus 3 Interactive</span></nuxt-link>
            <a class="main-nav-trigger"><span></span></a>
        </div>
        <nav class="main-nav">
            <ul>
                <li class="current-menu-item"><nuxt-link to="/solutions"><span class="icon icon-solutions"></span> Solutions <span class="nav-dropdown-arrow"></span></nuxt-link>
                    <ul>
                        <li><nuxt-link to="/solutions/our-process"><span class="icon icon-solutions"></span> Our Process</nuxt-link></li>
                    </ul>
                </li>
                <li><nuxt-link to="/projects"><span class="icon icon-projects"></span> Projects</nuxt-link></li>
                <li><nuxt-link to="/company"><span class="icon icon-company"></span> Company</nuxt-link></li>
                <li><nuxt-link to="/contact"><span class="icon icon-contact"></span> Contact Us</nuxt-link></li>
                <li><nuxt-link to="/customer-login"><span class="icon icon-login"></span> Customer Login</nuxt-link></li>
            </ul>
            <div class="main-nav-social">
                Follow Us
                <nuxt-link to="/"><span class="icon icon-instagram"></span></nuxt-link>
                <nuxt-link to="/"><span class="icon icon-twitter"></span></nuxt-link>
                <nuxt-link to="/"><span class="icon icon-facebook"></span></nuxt-link>
            </div>
        </nav>
    </header><!-- header -->

</template>
<script>
  export default {
    mounted () {
      $('.main-nav-trigger').on('click', function() {
        $(this).toggleClass('is-open');
        $('.main-nav').toggleClass('is-open');
      });

      $('.nav-dropdown-arrow').on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().toggleClass('is-open');
      });
    }
  }
</script>
