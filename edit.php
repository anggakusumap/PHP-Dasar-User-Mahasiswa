<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: login.php");
    }

    require "functions.php";

    // id data url
    $id = $_GET["id"];

    // query data mahasiswa from id
    $id_mhs = query("SELECT*FROM tb_mahasiswa WHERE id = $id")[0];

    if(isset($_POST["submit"])){
        //check edit data success
        if (edit($_POST) > 0){
            echo "
                <script>
                    alert ('Data Berhasil Diubah!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else{
            echo "
                <script>
                    alert ('Data Gagal Diubah!');
                    document.location.href = 'index.php';
                </script>
            ";
            echo mysqli_error($conn);
        }
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Edit Data Siswa!</title>
</head>
<body>
    <h1>Edit Data Mahasiswa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id_mhs["id"]; ?>">
        <input type="hidden" name="gambar_lama" value="<?= $id_mhs["gambar"]; ?>">
        <ul>
            <li>
                <label for="nama">Nama: </label>
                <input type="text" name="nama" id="nama" required value="<?= $id_mhs["nama"]; ?>">
            </li>
            <li>
                <label for="nim">NIM: </label>
                <input type="text" name="nim" id="nim" required value="<?= $id_mhs["nim"]; ?>">
            </li>
            <li>
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required value="<?= $id_mhs["email"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan: </label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $id_mhs["jurusan"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar: </label>
                <img src="img/<?= $id_mhs["gambar"]; ?>" width="100"> <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Update Data!</button>
            </li>
        </ul>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>