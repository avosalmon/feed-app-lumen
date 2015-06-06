var http  = require('http');
var shell = require('shelljs');

var ip    = "0.0.0.0";
var app   = process.argv[2];
var port  = process.argv[3];

if(typeof app === 'undefined' || typeof port === 'undefined') {
    console.log('');
    console.log('Not enough arguments.');
    console.log('Usage:');
    console.log('  node gulpserver.js <app> <port>');
    console.log('Example:');
    console.log('  node gulpserver.js response-module-laravel 9121');
    console.log('');
    process.exit(1);
}

var server = http.createServer(function (request, response) {
  response.writeHead(200, {"Content-Type": "text/plain"});

  shell.exec("app sync_pull " + app);
  //shell.echo("\n");

  //response.end("\n");
  response.end();
});

server.listen(port, ip);

console.log("Server running at http://" + ip + ":" + port + "/");
