<?php

$conn = mysqli_connect("localhost","root","","latihanrifda");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;

    }
    return $rows;
}

function tambah($datarifda1){
	//ambil data dari tiap elemen dalam form
	global $conn;
	
	$no_absen = htmlspecialchars($datarifda1["no_absen"]);
	$nama = htmlspecialchars($datarifda1["nama"]);
	$kelas = htmlspecialchars($datarifda1["kelas"]);
    $alamat = htmlspecialchars($datarifda1["alamat"]);
    $hobi = htmlspecialchars($datarifda1["hobi"]);
	$gambar = htmlspecialchars($datarifda1["gambar"]);

	$gambar = upload();
	if(!$gambar){
		return false;
	}


	//query insert data
	$query = "INSERT INTO datarifda1
		VALUES
        ('', '$no_absen', '$nama', '$kelas', '$alamat', '$hobi','$gambar')
	";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);


}

function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM datarifda1 WHERE id = $id");
	return mysqli_affected_rows($conn);
}
function ubah($datarifda1){
	global $conn;
	$id=$datarifda1["id"];
	$no_absen = htmlspecialchars($datarifda1["no_absen"]);
	$nama = htmlspecialchars($datarifda1["nama"]);
	$kelas = htmlspecialchars($datarifda1["kelas"]);
	$alamat = htmlspecialchars($datarifda1["alamat"]);
	$hobi = htmlspecialchars($datarifda1["hobi"]);
	$gambarLama = htmlspecialchars($datarifda1["gambarLama"]);

	if($_FILES['gambar']['error']===4){
		
		$gambar = $gambarLama;
	}else{
		$gambar = upload();
	}

	//query insert data
	$query = "UPDATE datarifda1 SET
		no_absen = '$no_absen',
		nama = '$nama',
		kelas = '$kelas',
		alamat = '$alamat',
		hobi = '$hobi',
		gambar = '$gambar'
		WHERE id = $id
	";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function upload(){
	$namaFile =$_FILES['gambar']
	['name'];
	$ukuranFile =$_FILES['gambar']
	['size'];
	$error =$_FILES['gambar']
	['error'];
	$tmpName =$_FILES['gambar']
	['tmp_name'];

	if($error === 4){
		echo "<script>
		alert('Silahkan pilih gambar dulu!');
		</script>";
		return false;
	}

	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = explode('.',$namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar,$ekstensiGambarValid)){
		echo "<script>
		alert('Yang Anda upload bukan gambar!');
		</script>";
		return false;
	}
	
	if($ukuranFile > 10000000){
		echo "<script>
		alert('Ukuran file yang Anda upload terlalu besar!');
		</script>";
		return false;
	}

	$namaFileBaru = uniqid();
	$namaFileBaru = '.';
	$namaFileBaru = 
	$ekstensiGambar;

	move_uploaded_file($tmpName,'gambar/'.$namaFileBaru);
	return $namaFileBaru;
}

function cari($keyword){
	$query = "SELECT * FROM datarifda1 
	WHERE
	no_absen LIKE '%$keyword%' OR 
	nama LIKE '%$keyword%' OR
	alamat LIKE '%$keyword%' OR
	kelas LIKE '%$keyword%' OR
	hobi LIKE '%$keyword%' 
	";
	return query($query);

}

function registrasi($datarifda1){
	global $conn;

	$username =  strtolower(stripcslashes($datarifda1["username"]));
	$password = mysqli_real_escape_string($conn, $datarifda1["password"]);
	$password2 = mysqli_real_escape_string($conn, $datarifda1["password2"]);

	$result = mysqli_query($conn,"SELECT username FROM userrifda WHERE username = '$username'");
	if(mysqli_fetch_assoc($result)) {
		echo "<script>
		alert('username sudah terdaftar!')
		</script>";
		return false;
	}


	
	if($password !== $password2){
		echo "<script>
		alert  ('konfirmasi password tidak sesuai!');
		</script>";
		return false;
	}
	
	$password = password_hash($password, PASSWORD_DEFAULT);

	
	mysqli_query($conn, "INSERT INTO userrifda VALUES('', '$username', '$password')");
	return mysqli_affected_rows($conn);

}

?>