<?php include_once 'lib/header.php';


    $cur_email = "";
    $nama = "";
    $nohp = "";
    $first_time = true;
    if($first_time){
        $first_time = false;
        if(isset($_GET['id'])){
            include 'lib/koneksi.php';
            $cur_email = $_GET['id'];
            $sql = "CALL `get_peserta`('$cur_email', '');";
            
            $data = mysqli_query($conn, $sql);
            if(mysqli_num_rows($data) > 0){
                while ($row = mysqli_fetch_assoc($data)):
                    $cur_email = $row['email'];
                    $nama = $row['nama'];
                    $nohp = $row['nohp'];
                endwhile;
            }else{
                $cur_email = "";
            }
            $conn->close();
        }
    }

    if(isset($_POST['simpan'])){
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $nohp = $_POST['nohp'];
        $password = $_POST['password'];
        $hashed_password = '';
        $newFilePath = '';

        if(strlen($password) > 0){
            $hashed_password = hash("sha512", $password);
        }
        
        if(isset($_FILES['foto']['name'])){
            $cur_file = $_FILES['foto']['name'];
            $tmpFilePath = $_FILES['foto']['tmp_name'];
            $ext = strtolower(pathinfo($cur_file, PATHINFO_EXTENSION));
            if($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg'){
                if ($tmpFilePath != ""){
                    $t_nama_file = md5(uniqid()).".".$ext;

                    $newFilePath = "gambar_peserta/" . $t_nama_file;
                
                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {}
                }
            }
        }

        if(strlen($cur_email) > 0){
            $sql = "
                CALL `add_peserta`('$email', '$hashed_password', '$nama', '$nohp', '$cur_email', '$newFilePath', 0);
            ";
        }else{
            $sql = "
                CALL `add_peserta`('$email', '$hashed_password', '$nama', '$nohp', NULL, '$newFilePath', 1);
            ";
        }

        include 'lib/koneksi.php';
        if(mysqli_query($conn, $sql)){
            echo "<script language=\"javascript\">window.location.href = 'peserta.php';</script>";
        }else{
            echo "<script language=\"javascript\">alert(\"Gagal simpan data peserta!\");</script>";
        }
        $conn->close();
        
    }
?>

<h1 class="text-center mt-3">Tambah/Edit Peserta</h1>

<div class="card ml-3 mr-3">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" required value="<?=$cur_email?>">
            </div>
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required value="<?=$nama?>">
            </div>
            <div class="form-group">
                <label for="nohp">No. HP</label>
                <input type="text" class="form-control" id="nohp" name="nohp" required value="<?=$nohp?>">
            </div>
            <div class="form-group">
                <label for="foto">Gambar</label>
                <input class="form-control-file" type="file" id="foto" name="foto">
            </div>
            <div class="form-group">
                <label for="password" id="password_label">Password (Kosong = Tidak diubah)</label>
                <input type="text" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-success" id="simpan" name="simpan" value="simpan">Simpan</button>
        </form>
    </div>
</div>


<script>
    var cur_email = "<?=$cur_email?>";
    if(cur_email.length == 0){
        var elem1 = document.getElementById("password");
        elem1.required = true;
        var elem2 = document.getElementById("password_label");
        elem2.innerHTML = "Password";
        var elem3 = document.getElementById("foto");
        elem3.required = true;
    }
</script>

<?php 
    include_once 'lib/footer.php';
?>
