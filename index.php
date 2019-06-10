<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: login.php");
    }

    require'functions.php';

    // pagination configuration
    $dataPerPage = 4;
    $totalData = count(query("SELECT*FROM tb_mahasiswa"));
    $totalPage = ceil($totalData / $dataPerPage);
    $activePage = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $firstData = ($dataPerPage * $activePage) - $dataPerPage;

    $mahasiswa = query("SELECT*FROM tb_mahasiswa ORDER BY id DESC LIMIT $firstData, $dataPerPage");

    // search button logic
    if (isset($_POST["search"])){
        $mahasiswa = search($_POST["keyword"]);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Halaman Admin</title>
</head>
<body>
    <center>
    <a href="logout.php">LOGOUT</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="create.php">Create Data Mahasiswa</a>
    <form action="" method="post">
        <input type="text" name="keyword" placeholder="Input Keyword" autofocus autocomplete="off">
        <button type="submit" name="search">Search!</button>
    </form>
    <br>
    <!-- Navigation Pagination -->
    <?php if($activePage > 1):?>
        <a href="?halaman=<?= $activePage - 1 ?>">&laquo;</a>
    <?php endif;?>

    <?php for($i = 1; $i <= $totalPage; $i++) :?>
        <?php if($i == $activePage) : ?>
            <a href="?halaman=<?= $i?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
        <?php else : ?>
            <a href="?halaman=<?= $i?>"><?= $i; ?></a>
        <?php endif; ?>
    <?php endfor;?>

    <?php if($activePage < $totalPage):?>
        <a href="?halaman=<?= $activePage + 1 ?>">&raquo;</a>
    <?php endif;?>

    <br><br>
    <table border="1" cellpadding="10" cellspacing="0" class="text-center">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
        </thead>
        <?php $i = 1 ?>
        <?php foreach ($mahasiswa as $mhs) :?>
        <tbody>
            <tr>
                <td><?= $i + $firstData ?></td>
                <td>
                    <a href="edit.php?id=<?= $mhs["id"]; ?>">Edit</a> |
                    <a href="delete.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Are You Sure for Delete Data?');">Delete</a>
                </td>
                <td>
                    <img src="img/<?= $mhs["gambar"];?>" width="50">
                </td>
                <td><?= $mhs["nama"];?></td>
                <td><?= $mhs["nim"];?></td>
                <td><?= $mhs["email"];?></td>
                <td><?= $mhs["jurusan"];?></td>
            </tr>
        </tbody>
        <?php $i++; ?>
        <?php endforeach;?>
    </table>
    </center>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>