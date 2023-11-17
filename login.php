<?php

require 'function.php';


if(isset($_POST["login"])){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM userrifda WHERE username = '$username'");

	if(mysqli_num_rows($result) === 1){

		$row = mysqli_fetch_assoc($result);
		if(password_verify($password, $row["password"])){

			
			$_SESSION["login"] = true;

			
			if(isset($_POST['remember'])){
				
				setcookie('login', 'true', time()+60);
			}



			header("Location: index.php");
			exit;
		}
	}

			$error = true;
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="ulang.css">
</head>
<body>

<center><h1>Halaman Login</h1></center>


<?php if(isset($error)): ?>

<p style="color: red;font-style: italic;">username atau password Anda salah!</p>

<?php endif; ?>


<form class="kotak_login" action="" method="post">
	<center>
		<div>
		<div>
			<label for="username">Username</label></div>
		<div>	<input type="text" name="username" class="form_login" id="username">
		</div>
		<br>
		<div>
			<label for="password">Password</label></div>
		<div><input type="password" name="password" class="form_login" id="password">
		</div>
<br>
		<div>
		<input type="checkbox" name="remember" id="remember">
		<label align="center" for="remember">Remember Me:</label>	
<br>
		</div>
		<br>
		<div>
			<button type="submit" class="tombol_login" name="login">Login</button>
		</div>
	</div></center>
	 
</form>
<br>
<center><button><a href="index.php?id=<?=$row["id"]; ?>">back</a></button>
<button><a href="registrasi.php?id=<?=$row["id"]; ?>">Registrasi</a></button></center>
</body>
</html>