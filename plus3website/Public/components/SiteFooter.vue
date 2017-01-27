<template>
    <footer class="footer">
        <div class="footer-buttons">
            <a href="" class="btn-footer"><span class="icon icon-contact"></span> Contact Us</a>
            <a href="#proposal-popup" class="btn-footer btn-proposal"><span class="icon icon-document"></span> Request a Proposal</a>
        </div>
        <div class="footer-bottom">
            <a href="" class="footer-logo"><span class="visually-hidden">Plus 3 Interactive</a>
            <nav class="footer-nav">
                <ul>
                    <li><a href="/solutions">Solutions</a></li>
                    <li><a href="/projects">Projects</a></li>
                    <li><a href="/company">Company</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                    <li><a href="/customer-login">Customer Login</a></li>
                </ul>
            </nav>
            <div class="footer-social">
                <a href=""><span class="icon icon-instagram"></span></a>
                <a href=""><span class="icon icon-twitter"></span></a>
                <a href=""><span class="icon icon-facebook"></span></a>
            </div>
        </div>
        <div class="footer-copyright">
            <p>&copy;2010-{{ new Date().getFullYear() }} Plus 3 Interactive LLC All Rights Reserved</p>
        </div>
    </footer><!-- footer -->

</template>

<script>
  export default {
    mounted () {
      $('.btn-proposal').magnificPopup({
        type:'inline',
        closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
      });
    }
  }
</script>
