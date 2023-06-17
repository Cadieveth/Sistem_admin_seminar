<?php
    session_start();
    if (!isset($_SESSION['uname']) || !isset($_SESSION['pass'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['id_seminar']) && isset($_GET['email'])){
        $id_seminar = $_GET['id_seminar'];
        $email = $_GET['email'];
        
        include "lib/koneksi.php";
        
        $sql = "CALL `get_peserta_seminar`($id_seminar, '$email');";
        $data = mysqli_query($conn, $sql);
        
        $hadir = null;
        while($row = mysqli_fetch_assoc($data)){
            $hadir = $row['hadir'];
            if($hadir == 0){
                $hadir = 1;
            }
        }

        $conn->close();

        if($hadir != null):
            include "lib/koneksi.php";

            $sql = "CALL `add_peserta_seminar`($id_seminar, '$email', $hadir);";

            if(mysqli_query($conn, $sql)){}

            $conn->close();
        endif;
    }
    header("Location: peserta_seminar.php");
    exit;
?>