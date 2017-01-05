var merge = require('webpack-merge')
var server = require('./server.env.js')

module.exports = merge(server, {
  NODE_ENV: '"production"',
  DEBUG_MODE: false
})
