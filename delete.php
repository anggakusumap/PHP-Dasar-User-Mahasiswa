<?php
    session_start();

    if(!isset($_SESSION["login"])){
        header("Location: login.php");
    }

    require "functions.php";

    $id = $_GET["id"];

    if (delete($id) > 0){
        echo "
            <script>
                alert ('Data Berhasil Dihapus!');
                document.location.href = 'index.php';
            </script>
        ";
    } else{
        echo "
            <script>
                alert ('Data Gagal Dihapus!');
                document.location.href = 'index.php';
            </script>
        ";
        echo mysqli_error($conn);
    }
?>