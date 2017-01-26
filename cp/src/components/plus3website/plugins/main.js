// right now we just use this file to define some global variables, most of
// which can prob just be defined in nuxt.config.js
if (process.BROWSER_BUILD) {
    window.$ = require('jquery')
    window.FormsJquery = require('~assets/js/forms.js')
    window.Snap = require('imports-loader?this=>window,fix=>module.exports=0!~assets/js/snap.svg-min.js')

    window.breakpoints = {large: 1200, medium: 992, small:768 , xsmall:767 };
}
