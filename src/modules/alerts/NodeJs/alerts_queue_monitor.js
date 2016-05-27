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

var privateKey = fs.readFileSync(__dirname + '/certs/key').toString();
var certificate = fs.readFileSync(__dirname + '/certs/crt').toString();

var options = {
    cert: certificate,
    key: privateKey
}

var app = https.createServer(options);
// var app = http.createServer(function(){
    // console.log("Dunno")
// });

var io = require('socket.io')(app);

var Redis = require('ioredis');

var redis = new Redis({
    port: 6379,
    host: '127.0.0.1',
    db: 0
});

app.listen(3001, function() {
    console.log('Server is running!');
});

redis.subscribe('test-channel', function(err, count) {
    console.log('Subscribed to test-channel');
});

io.on('connection', function(socket) {
    console.log('Client Connected');
});

redis.on('message', function(channel, message) {
    var message = JSON.parse(message);
    io.emit(channel, message.data);
});