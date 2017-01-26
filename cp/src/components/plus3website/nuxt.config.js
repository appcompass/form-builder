module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: '%s - Plus 3 Interactive',
    script: [
      // { src: 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js' }
    ],
    link: [
      { rel: 'stylesheet', href: 'https://fast.fonts.net/cssapi/e1ef451d-c61f-4ad3-b4e0-e3d8adb46d89.css' }
    ],
    meta: [
      { charset: 'utf-8' },
      { 'http-equiv': 'x-ua-compatible', content: 'ie=edge' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', content: "Plus 3 Interactive, LLC" }
    ],
    link: [
      { rel: 'icon', type: 'image/png', href: '/favicon.png' }
    ]
  },
  /*
  ** Global CSS
  */
  css: [
    { src: '~assets/sass/main.scss', lang: 'sass' }
    // '~assets/css/main.css'
  ],
  build: {
    filenames: {
      css: 'app.css',
      vendor: 'vendor.js',
      app: 'app.js'
    },
    vendor: [
      'jquery',
      'jquery-match-height',
      'magnific-popup',
      'slick-carousel',
      'imports-loader'
    ]
  },
  plugins: [
    '~plugins/ga.js',
    '~plugins/main.js'
  ],
  /*
  ** Customize the progress-bar color
  */
  loading: {
    height: '3px',
    color: '#0ab7f9'
  }
}
