<?php 
session_start();
if( !isset($_SESSION['login']) ) {
    header("Location: login.php");
    exit;
}

require('functions.php');

// PAGINATION
// konfigurasi
// berapa data perhalaman
$jumlahDataPerhalaman = 2;

// jumlah halaman yang akan ditampilkan
$jumlahData = count( query("SELECT * FROM mahasiswa") );
$jumlahHalaman = ceil( $jumlahData / $jumlahDataPerhalaman );

// operator ternary
$halamanAktif = ( isset($_GET['halaman']) ) ? $_GET['halaman'] : 1;

// formula
$awalData = ( $jumlahDataPerhalaman * $halamanAktif ) - $jumlahDataPerhalaman;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman");

// Pagination ends


// tombil cari ditekan
if( isset($_POST['cari']) ){
    $mahasiswa = cari($_POST['keyword']);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DATA MAHASISWA</title>
</head>
<body>
    <a href="logout.php">Log out</a>
    <h1>Data Mahasiswa</h1>

    <a href="create.php">Tambah Data</a><br><br>

    <!-- SEARCH -->
    <form action="" method="post">
        <input type="text" name="keyword" autofocus placeholder="masukkan..." autocomplete="off">
        <button type="cari" name="cari" >Cari</button>
    </form>

    <!-- NAVIGASI PAGINATION -->

    <?php if( $halamanAktif > 1 ) : ?>
        <a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
    <?php endif; ?>

    <?php for($i = 1; $i < $jumlahHalaman; $i++ ) : ?>
        <?php if( $i == $halamanAktif ) : ?>
            <a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"> <?= $i; ?> </a>
        <?php else : ?>
            <a href="?halaman=<?= $i; ?>" > <?= $i; ?> </a>
        <?php endif; ?>
    <?php endfor; ?>

    <?php if( $halamanAktif < $jumlahHalaman ) : ?>
        <a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>No.</th>
            <th>Opsi</th>
            <th>Foto</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        
        <?php $i = 1; ?>
        <?php foreach( $mahasiswa as $mhs ) : ?>
        <tr>
            <td> <?php echo $i++;  ?> </td>
            <td>
                <a href="update.php?id=<?= $mhs['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?= $mhs['id']; ?>" onclick="return confirm('mau hapus data <?= $mhs['nama']; ?>?');">Hapus</a>
            </td>
            <td> <img src="img/<?= $mhs['foto']; ?>" alt="" width="50px" height="50px"> </td>
            <td> <?= $mhs['nrp']; ?></td>
            <td> <?= $mhs['nama']; ?></td>
            <td> <?= $mhs['email']; ?></td>
            <td> <?= $mhs['jurusan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>



    <script src="js/sript.js"></script>
</body>
</html>