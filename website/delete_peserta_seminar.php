<?php
    session_start();
    if (!isset($_SESSION['uname']) || !isset($_SESSION['pass'])){
        header("Location: login.php");
        exit;
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        include_once "lib/koneksi.php";
        
        $sql = "CALL `delete_peserta_seminar`($id, 0);";

        if(mysqli_query($conn, $sql)){}
        $conn->close(); 
    }
    header("Location: peserta_seminar.php");
    exit;
?>