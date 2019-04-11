<?php 
// membangun koneksi

// definisi
$host = 'localhost';
$db = 'prosedural';
$user = 'root';
$pass = '';

$conn = mysqli_connect($host, $user, $pass, $db);

// Query menampilkan isi tabel
function query($query){
    global $conn;
    
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ){
        $rows[] = $row;
    }
    return $rows;
}

function create($data) {
    global $conn;

    $nrp = htmlspecialchars($_POST['nrp']);
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jurusan = htmlspecialchars($_POST['jurusan']);

    //upload gambar
    $foto = upload();
    if( !$foto ){
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('','$nrp','$nama','$email','$jurusan','$foto')";
    // var_dump($query); die;
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {
    $namaGambar = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $tmpName = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    //cek apa  tidak ada gambar
    if ( $error === 4 ){
        echo "
            <script>
                alert('tidak ada gambar');
            </script>
        ";

        return false;
    }

    //cek ekstensi gambar
    $ekstensiGambarValid = ['jpg','jpeg','png'];
    $ekstensiGambar = explode('.', $namaGambar);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
        echo "
            <script>
                alert('gambar tidak valid');
            </script>
        ";

        return false;
    }

    //cek ukuran file
    if( $ukuran > 1000000 ){
        echo "
            <script>
                alert('gambar terlalu besar');
            </script>
        ";

        return false;
    }

    //lolos cek, gambar siap uploas
    //generate nama fuli
    $namaGambarBaru = uniqid();
    $namaGambarBaru .= '.';
    $namaGambarBaru .= $ekstensiGambar;


    move_uploaded_file($tmpName, 'img/' . $namaGambarBaru);

    return $namaGambarBaru;
}

function update($data){
    global $conn;

    $id = $data['id'];
    $nrp = htmlspecialchars($data['nrp']);
    $nama = htmlspecialchars($data['nama']);
    $email = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $fotoLama = $data['fotoLama'];

    //cek apakah ganti gambar
    if( $_FILES['gambar']['error'] === 4 ) {
        $foto = $fotoLama;
    } else {
        $foto = upload();
    }

    $query = "UPDATE mahasiswa SET
        nrp = '$nrp',
        nama = '$nama',
        email = '$email',
        jurusan = '$jurusan',
        foto = '$foto'
    WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function del($id) {
    global $conn;

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    global $conn;

    $query = "SELECT * FROM mahasiswa
              WHERE
              nama LIKE '%$keyword%' OR
              email LIKE '%$keyword%'
              ";
    
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    //cek username
    if( mysqli_fetch_assoc($result) ) {
        echo "username sudah ada";
        
        return false;
    }

    //cek password
    if( $password !== $password2 ) {
        echo "password tidak sesuai";

        return false;
    }
    //enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    //insert kedalam database
    mysqli_query($conn, "INSERT INTO user VALUES('','$username','$password')");

    return mysqli_affected_rows($conn);
}

?>