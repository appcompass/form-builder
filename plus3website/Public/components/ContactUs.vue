<template>
    <div class="section-pad">
        <div class="row">
            <div class="medium-8 medium-centered columns">
                <form>
                    <div class="row">
                        <div class="small-6 columns">
                            <label for="" class="inside">*First Name</label>
                            <input type="text" value="">
                        </div>
                        <div class="small-6 columns">
                            <label for="" class="inside">*Last Name</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-6 columns">
                            <label for="" class="inside">*Email</label>
                            <input type="email">
                        </div>
                        <div class="small-6 columns">
                            <label for="" class="inside">*Phone</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-6 columns">
                            <label for="" class="inside">*Company Name</label>
                            <input type="text">
                        </div>
                        <div class="small-6 columns">
                            <label for="" class="inside">*Company Website</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns">
                            <label for="" class="inside">*Your Message</label>
                            <textarea rows="8"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns text-right">
                            <button class="btn-blue">Send <span class="icon-arrow"></span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    mounted () {
      FormsJquery.init();
    }
  }
</script>
