<?php
$client = new http\Client;
$request = new http\Client\Request;
$request->setRequestUrl('https://account.flexem.com/core/connect/token');
$request->setRequestMethod('POST');
$body = new http\Message\Body;
$body->append(new http\QueryString(array(
  'username' => 'erdem3801',
  'password' => 'erdem3801.',
  'scope' => 'openid offline_access fbox email profile',
  'client_id' => 'ebae',
  'client_secret' => '2def71770779de31ba196d9423735368',
  'grant_type' => 'password')));$request->setBody($body);
$request->setOptions(array());
$request->setHeaders(array(
  'Content-Type' => 'application/x-www-form-urlencoded'
));
$client->enqueue($request)->send();
$response = $client->getResponse();
echo $response->getBody();