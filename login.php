<?php

$token =$_POST['token'];

$curl = curl_init();

  
  
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://fbox360.com/api/client/box/grouped",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$token
  ),
));

$response = curl_exec($curl);

curl_close($curl);



//print_r($response);
$dec = json_decode($response);




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://fbcs101.fbox360.com/api/v2/box/dmon/grouped?boxNo=".$dec[0]->boxRegs[0]->box->boxNo,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
//echo $response;
$dec1 = json_decode($response);
$names = "[";
$groupname = "[";
for ($i=0; $i < count($dec1[0]->items) ; $i++) { 
  if($i==count($dec1[0]->items)-1)
  {
    $names .= "\"".$dec1[0]->items[$i]->name."\"";
    $groupname .= "\"".$dec1[0]->items[$i]->grpName."\"";
  }
  else
  {
    $names .= "\"".$dec1[0]->items[$i]->name."\",";
    $groupname .= "\"".$dec1[0]->items[$i]->grpName."\",";
  
  }
}
$names .= "]";
$groupname .= "]";



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://fbcs101.fbox360.com/api/v2/dmon/value/get?boxNo=".$dec[0]->boxRegs[0]->box->boxNo,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>"{\r\n\"names\":".$names.",\r\n\"groupnames\":".$groupname.",\r\n\"timeout\":null\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer ".$token,
    "Content-Type: application/json"
  ),
));

$response = curl_exec($curl);

curl_close($curl);

$dec2 = json_decode($response);
/*
for ($i=0; $i <count($dec[0]->boxRegs) ; $i++) 
$cihazlar ="<li class=\"nav-item active \"><a class=\"nav-link\"><i class=\"material-icons\" onclick=\"zaman()\">content_paste</i><p>".$dec[0]->boxRegs[$i]->alias."</p></a></li>";
 */




if( isset($_POST['veriler']) )
{
  for ($i=0; $i < count($dec2) ; $i++)  
  {
  $echoveriler ="<tr><td class=\"name\">".$dec2[$i]->id."</td><td class=\"name\">".$dec2[$i]->name."</td><td class=\"name\">".$dec2[$i]->boxId."</td><td class=\"name\">".$dec2[$i]->value."</td><td class=\"name\">".$dec2[$i]->dataType."</td></tr>";
  echo $echoveriler;
  }
}

if( isset($_POST['cihazlar']) )
{

for ($i=0; $i <count($dec[0]->boxRegs) ; $i++) 
{
$cihazlar ="<li class=\"nav-item active \"><a class=\"nav-link\"><i class=\"material-icons\" onclick=\"zaman()\">content_paste</i><p>".$dec[0]->boxRegs[$i]->alias."</p></a></li>";
echo $cihazlar;
}
  
}
//echo $cihazlar; 
 




?>







