<?php
session_start();
if( !isset($_SESSION['login']) ) {
    header("Location: login.php");
    exit;
}

require('functions.php');

//ambil data url
$id = $_GET['id'];

//query berdasar id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

if( isset($_POST['submit']) ){
    if( update($_POST) > 0 ){
        echo "
            <script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Mahasiswa</title>
</head>
<body>
    <a href="index.php">kembali</a>

    <h1>Form Edit Data</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <input type="hidden" name="id" value="<?= $mhs['id']; ?>">
                <input type="hidden" name="fotoLama" value="<?= $mhs['foto']; ?>">
            </li>
            <li>
                <label for="nrp">NRP</label><br>
                <input type="text" name="nrp" for="nrp" value="<?= $mhs['nrp']; ?>">
            </li>
            <li>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama" for="nama" value="<?= $mhs['nama']; ?>">
            </li>
            <li>
                <label for="email">Email</label><br>
                <input type="email" for="email" name="email" value="<?= $mhs['email']; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan</label><br>
                <input type="text" name="jurusan" for="jurusan" value="<?= $mhs['jurusan']; ?>">
            </li>
            <li>
                <label for="foto">Foto</label><br>
                <img src="img/<?= $mhs['foto']; ?>" alt="" width="50px" height="50px"><br>
                <input type="file" name="foto" for="foto">
            </li>
            <hr>
            <button type="submit" name="submit">Edit Data</button>
        </ul>

        
    </form>
</body>
</html>