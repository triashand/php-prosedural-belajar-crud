<?php
    session_start();
    if( !isset($_SESSION['login']) ) {
        header("Location: login.php");
        exit;
    }
    
    require('functions.php');

    if( isset($_POST['submit']) ){
        // cek apakah data ditambah
        if( create($_POST) > 0 ){
            echo "
                <script>
                alert('data berhasil');
                document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                alert('data gagal');
                document.location.href = 'create.php';
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
    <title>Tambah Data Mahasiswa</title>
</head>
<body>
    <a href="index.php">kembali</a>

    <h1>Form Tambah Data</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nrp">NRP</label><br>
                <input type="text" name="nrp" for="nrp" required>
            </li>
            <li>
                <label for="nama">Nama</label><br>
                <input type="text" name="nama" for="nama" required>
            </li>
            <li>
                <label for="email">Email</label><br>
                <input type="email" for="email" name="email" required>
            </li>
            <li>
                <label for="jurusan">Jurusan</label><br>
                <input type="text" name="jurusan" for="jurusan">
            </li>
            <li>
                <label for="foto">Foto</label><br>
                <input type="file" name="foto" for="foto">
            </li>
            <hr>
            <button type="submit" name="submit">Tambah</button>
        </ul>

        
    </form>
</body>
</html>