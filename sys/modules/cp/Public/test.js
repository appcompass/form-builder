var fs = require("fs")
var browserify = require('browserify')
var vueify = require('vueify')

browserify('./maintest.js')
  .transform(vueify)
  .bundle()
  .pipe(fs.createWriteStream("out.js"))
