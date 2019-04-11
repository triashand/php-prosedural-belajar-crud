<?php 
require('functions.php');

if( isset($_POST['register']) ) {
    if( registrasi($_POST) > 0 ) {
        echo "
            <script>
                alert('user berhasil ditambah');
                document.location.href = 'login.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('user gagal ditambah');
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
    <title>Registrasi</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Halaman Registrasi</h1>
    
    <form action="" method="post">
        <label for="username">username :</label>
        <input type="text" for="username" name="username">
        <label for="password">password :</label>
        <input type="password" for="password" name="password">
        <label for="password2">konfirmasi password :</label>
        <input type="password" for="password2" name="password2"><br>

        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>