

<!DOCTYPE html>
<html>
	<head>

	
        <title>Erdem</title>
		<link rel="stylesheet" href="index.css">
	</head>
	<body>
		<div class="login-form">
			<h1>Alba Elektronik</h1>
			<form  method="POST">
				<input type="text" name="username" placeholder="Username" required>
				<input type="password" name="password" placeholder="Password" required>
				<input type="submit" value="LOG IN"> 
            </form>
            <h4> Forgot your password?.php</h4>
            <h5>Don't have an account? <a href="#">Sing up</a></h5>

		</div>
	
		

	</body>

</html>

<?php

if($_POST)
{
$accestoken = deger();
}
if($_GET){
echo($accestoken);

}


function deger(){



    $curl = curl_init();

$user = $_POST['username'];
$pass = $_POST['password'];

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://account.flexem.com/core/connect/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "username=".$user."&password=".$pass."&scope=openid%20offline_access%20fbox%20email%20profile&client_id=ebae&client_secret=2def71770779de31ba196d9423735368&grant_type=password",
  CURLOPT_HTTPHEADER => array(

  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."<br>";
$arr = json_decode($response, true);
if($arr["access_token"])
{
    echo $arr["access_token"];
    
    header("Location:login.html?token=".$arr["access_token"]);
   
    return $arr["access_token"];

}
else
{
    echo "yanlış kullanıcı adı veya şifre";
    return "error";
}

}

?>


