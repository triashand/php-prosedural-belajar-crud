<?php
session_start();

require('functions.php');

// cek cookie sebelum cek session
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username dari db
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = '$id'");

    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username
    if( $key === hash('sha256', $row['username']) ) {
        $_SESSION['login'] = true;        
    }

    // if( $_COOKIE['login'] == 'true' ) {
    //     $_SESSION['login'] == true;
    // }
}

if( isset($_SESSION['login']) ) {
    header("Location: index.php");
    exit;
}

if( isset($_POST['login']) ){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if( mysqli_num_rows($result) === 1 ) {
        
        //cek password
        $row = mysqli_fetch_assoc($result);

        //password_verify, cek password
        if( password_verify($password, $row['password']) ) {

            //sebelum masuk index, buat session, jalankan session paling atas
            $_SESSION['login'] = true;

            // cek cookie - remember me
            if( isset($_POST['remember']) ) {
                //buat cookie
                setcookie( 'id', $row['id'], time() + 60 );
                setcookie( 'key', hash('sha256', $row['username']), time() + 60 );
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
    <style>
        label {
            display: block;
        }
    </style>
</head>
<body>
    <h1>Form Login</h1>

    <?php if( isset($error) ) : ?>
        <p style="color: red">username / password salah!</p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="username">username :</label>
        <input type="text" for="username" name="username">
        <label for="password">password :</label>
        <input type="password" for="password" name="password">
        <!-- fitur remember me atau cookie -->
        <input type="checkbox" for="remember" name="remember">
        <label for="remember">remember me</label>

        <button type="submit" name="login">Login</button>

        <a href="register.php">Daftar Baru</a>
    </form>
</body>
</html>