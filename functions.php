<?php
    //connect to database
    $conn = mysqli_connect("localhost", "root", "", "db_belajar");

    //query data tb_mahasiswa
    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
    return $rows;
    }

    //create data mahasiswa
    function create($data){
        global $conn;
        //elemen data form
        $nama = $data["nama"];
        $nim = $data["nim"];
        $email = $data["email"];
        $jurusan = $data["jurusan"];

        // upload gambar
        $gambar = upload();
        if (!$gambar){
            return false;
        }

        //query insert data
        $query = "INSERT INTO tb_mahasiswa VALUES ('', '$nama', '$nim', '$email', '$jurusan', '$gambar')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    // upload function
    function upload (){
        $name_file = $_FILES['gambar']['name'];
        $size_file = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmp_name = $_FILES['gambar']['tmp_name'];

        // cek no uploaded file
        if ($error === 4){
            echo "
                <script>
                    alert('No Picture File!');
                </script>
            ";
            return false;
        }

        // picture validation
        $ekstensi_gambar_valid = ['jpg', 'png', 'jpeg'];
        $ekstensi_gambar = explode('.', $name_file);
        $ekstensi_gambar = strtolower(end($ekstensi_gambar));
        if(!in_array($ekstensi_gambar, $ekstensi_gambar_valid)){
            echo "
                <script>
                    alert('File Must a Picture (JPG, PNG, JPEG)!');
                </script>
            ";
            return false;
        }

        if($size_file > 1000000){
            echo "
                <script>
                    alert('File Too Big!');
                </script>
            ";
            return false;
        }

        // go upload
        $uniq_file = uniqid();
        $uniq_file .= '.';
        $uniq_file .= $ekstensi_gambar;
        move_uploaded_file($tmp_name, 'img/'. $uniq_file);
        return $uniq_file;
    }

    //delete data mahasiswa
    function delete ($id){
        global $conn;
        mysqli_query($conn, "DELETE FROM tb_mahasiswa WHERE id = $id");
        return mysqli_affected_rows($conn);
    }

    // update data mahasiswa
    function edit ($data){
        global $conn;
        //elemen data form
        $id = $data["id"];
        $nama = $data["nama"];
        $nim = $data["nim"];
        $email = $data["email"];
        $jurusan = $data["jurusan"];
        $gambar_lama = $data["gambar_lama"];
        $gambar = $data["gambar"];

        // check new picture
        if($_FILES['gambar']['error'] === 4){
            $gambar = $gambar_lama;
        } else{
            $gambar = upload();
        }

        //query insert data
        $query = "UPDATE tb_mahasiswa SET
                    nama = '$nama',
                    nim = '$nim',
                    email = '$email',
                    jurusan = '$jurusan',
                    gambar = '$gambar'
                    WHERE id = $id";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    // search function
    function search ($keyword){
        $query = "SELECT*FROM tb_mahasiswa WHERE 
                    nama LIKE '%$keyword%' OR
                    nim LIKE '%$keyword%' OR
                    email LIKE '%$keyword%' OR
                    jurusan LIKE '%$keyword%'
                ";
        return query($query);
    }

    // register function
    function register ($data){
        global $conn;

        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $confirm_password = mysqli_real_escape_string($conn, $data["confirm_password"]);

        // check username already exist
        $result = mysqli_query($conn, "SELECT username FROM tb_user WHERE username = '$username'");
        if(mysqli_fetch_assoc($result)){
            echo"
                <script>
                alert ('Username Already Exist!')
                </script>
            ";
            return false;
        }

        // check confirm password
        if($password != $confirm_password){
            echo "
                <script>
                    alert('Password Not Match!');
                </script>
            ";
            return false;
        }

        // password encription
        $password = password_hash($password, PASSWORD_DEFAULT);

        // go to database
        mysqli_query($conn, "INSERT INTO tb_user VALUES('', '$username', '$password')");
        return mysqli_affected_rows($conn);
    }
?>