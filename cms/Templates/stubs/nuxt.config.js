module.exports = {
  /*
  ** Headers of the page
  */
  head: {
    titleTemplate: '%s - Site Name',
    script: [
      // { src: 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js' }
    ],
    link: [
      // { rel: 'stylesheet', href: 'https://external.font.css' }
      // { rel: 'icon', type: 'image/png', href: '/favicon.png' }
    ],
    meta: [
      { charset: 'utf-8' },
      { 'http-equiv': 'x-ua-compatible', content: 'ie=edge' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', content: "Plus 3 Interactive, LLC" }
    ]
  },
  /*
  ** Global CSS
  */
  css: [
    // { src: '~assets/sass/main.scss', lang: 'sass' }
    // '~assets/css/main.css'
  ],
  build: {
    filenames: {
      css: 'app.css',
      vendor: 'vendor.js',
      app: 'app.js'
    },
    vendor: [
      // 'jquery'
    ]
  },
  plugins: [
    '~plugins/ga.js'
  ],
  /*
  ** Customize the progress-bar color
  */
  loading: {
    height: '3px',
    color: '#0ab7f9'
  }
}
