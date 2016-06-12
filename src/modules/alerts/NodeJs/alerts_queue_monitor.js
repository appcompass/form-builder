/**

    fire up a server
        secure server sic.
        keys
        certs
    pass server to socket constructor
    define port -> 3001
    app listen
    redis.subscribe
        redis on message push on socket

    KEEP IT SIMPLE FOR NOW!

    TBD vvvvvv

    final point is to just pass the hash + token around

    incoming socket push payload -> alert id // hash // ping
    frontend requests new alerts from the backend


*/

var https = require('https');
var http = require('http');
var fs = require('fs');

// get all environment variables and put htem into process.env
require('dotenv').config({path: __dirname + '/../../.env'});


var options = {
    cert: fs.readFileSync(process.env.SSL_CERTIFICATE, 'utf8'),
    key: fs.readFileSync(process.env.SSL_CERTIFICATE_KEY, 'utf8')
}

var app = https.createServer(options);

var io = require('socket.io')(app);

var Redis = require('ioredis');
//  process.env.REDIS_PASSWORD // is not used but is there if it's needed
var redis = new Redis({
    port: process.env.REDIS_PORT,
    host: process.env.REDIS_HOST,
    db: 0
});

app.listen(process.env.ALERTS_LISTEN_PORT, function() {
    console.log('Server is running!');
});

redis.psubscribe('*', function(err, count) {
    console.log('Subscribed to channels');
});

io.on('connection', function(socket) {
    console.log('Client Connected');
});

redis.on('pmessage', function(subscribe, channel, message) {
    console.log('Incoming message on ' + channel);
    var message = JSON.parse(message);
    io.emit(channel, message.data);
});