<?php
require  'function.php';

if(isset($_POST["register"])){
	if(registrasi($_POST) > 0){
		echo "<script>
		alert('user baru berhasil ditambahkan!');
		</script>";
	}else{
		echo mysqli_error($conn);
	}
}

?>




<!DOCTYPE html>
<html>
<head>
	<title>Halaman Registrasi</title>
	<link rel="stylesheet" type="text/css"href="ulang.css">
</head>
<body>

<center><h1>Halaman Registrasi</h1></center>
<form class="kotak_regis" action="" method="post">
	<center>
	<div>
		<div>
		<label for="username">username :</label>
		<input type="text" name="username" id="username">
	</div>
		<div>
			<br>
		<label for="password">password :</label>
		<input type="password" name="password" id="password">
	</div>
		<div>
			<br>
	    <label for="password2">konfirmasi password :</label>
		<input type="password" name="password2" id="password2">
	</div>
		<br>
		<div>
		<button type="submit" class="tombol_regis" name="register">
			Register!
		</button>
	</div></center>
	</div>



</form>
<br>
<center>
<button><a href="index.php?id=<?=$row["id"]; ?>">back</a></button>
<button><a href="login.php?id=<?=$row["id"]; ?>">Login</a></button></center>
</body>
</html>