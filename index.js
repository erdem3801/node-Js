var express = require('express');
var app = express();
var session = require('express-session');
var bodyParser = require('body-parser');
var path = require('path');
var querystring = require('querystring');
var request = require('request');


var keylog;
///****http listener flexem**********/
///******localhost starter **********/
app.use(session({
	secret: 'secret',
	resave: true,
	saveUninitialized: true
}));
app.use(bodyParser.urlencoded({extended : true}));
app.use(bodyParser.json());
app.use(express.static(__dirname));



app.get('/', function(request, response) {
	response.sendFile(path.join(__dirname + '/index.html'));
});
app.post('/login', function(reques, response) {
	var username = reques.body.username;
  var password = reques.body.password;
  var form = {
    username: username,
    password: password, 
    scope: 'openid offline_access fbox email profile',  
    client_id: 'ebae',
    client_secret: '2def71770779de31ba196d9423735368', 
    grant_type: 'password'
};
var formData = querystring.stringify(form);
var contentLength = formData.length;
console.log(contentLength);
  request({
    headers: 
    {
      'Content-Length': contentLength,
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    uri: 'https://account.flexem.com/core/connect/token',
    body: formData,
    method: 'POST'
  }, 
  function (err, resp, body) {
    //it works!
    console.log(body);
    try {
      const userStr = JSON.parse(body);
      keylog = 'Bearer ' +userStr.access_token;
      if(userStr.access_token!=undefined || userStr.access_token!=null)
      {
        
      reques.session.loggedin = true;
   
      response.redirect('home'); 
   
      }
      else
      {
    reques.session.loggedin = false;
    reques.session.username = username;
    response.redirect('home');
    }
    } 
    catch(err) {
      console.error(err)
      reques.session.loggedin = false;
      response.redirect('www.google.com');     
    }
  });
});
app.get('/home', function(req, response) {
	if (req.session.loggedin) {
    response.sendFile(path.join(__dirname + '/login.html'));
    getJSON("fifi");
	} else {
  
		response.sendFile(path.join(__dirname + '/index.html'));
	}
});
app.get('/logout', function(request, response) {
		response.sendFile(path.join(__dirname + '/index.html'));
});
app.listen(8080, function(){
    console.log('8080 portu aktif');
});

////**********htlm js cominications *********************/

function getJSON(callback) {
var form = {
  'Ids':[
    '155242225048377533',
    '155242264030239238',
    '155242336717528130',
    '155242363984698679',
    '155242403804372626',
    '155242437047377854',
    '155242473101611286',
    '155242507398435427',
    '155324583303862456',
    '155324825214539069',
    '155324864286578452',
    '155325710189614290'],
      'Groupnames':['Default Group'],
      'timeout':null};
var formData = JSON.stringify(form);
var contentLength = formData.length;
var seg =request({
  headers: 
  {
    'authorization': keylog,
  },
  uri: 'http://fbcs101.fbox360.com/api/v2/box/dmon/grouped?boxNo=338819020178',
  body: null,        
  method: 'GET'
}, 
function (err, re, bo) {
  //it works!
  console.log("keylog");
console.log(keylog);
  try {
    console.log('\n\n\n');         
    console.log(re.statusCode);
    console.log(JSON.parse(bo));
    console.log(bo);
    var d = new Date();
    var t = d.toLocaleTimeString();
    app.set('#verdik', 'correct battery horse staples');
  } 
  catch(err) {
    console.error(err);
  }
});
}

//setInterval(getJSON,2000);
//setTimeout(getJSON,2000);
