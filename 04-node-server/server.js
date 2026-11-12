const http = require("http");
http.createServer((req, res) => {
  res.setHeader("content-type", "text/html");
  res.end("<h1>04 Node server works</h1>");
}).listen(process.env.PORT || 8080);
