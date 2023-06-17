<?php
    session_start();
    if (!isset($_SESSION['uname']) || !isset($_SESSION['pass'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        include "lib/koneksi.php";
        
        $sql = "CALL `get_peserta`('$id', '');";
        $data = mysqli_query($conn, $sql);
        
        while($row = mysqli_fetch_assoc($data)){
            $path_gambar = $row['gambar'];
            if(strlen($path_gambar) > 0){
                unlink($path_gambar);
            }
        }

        $conn->close(); 
        
        include "lib/koneksi.php";
        
        $sql = "CALL `delete_peserta`('$id');";
        
        if(mysqli_query($conn, $sql)){}
        $conn->close(); 
    }
    header("Location: peserta.php");
    exit;
?>