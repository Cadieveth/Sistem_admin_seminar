<?php include_once 'lib/header.php';


    $cur_id = 0;
    $judul = "";
    $keterangan = "";
    $waktu = "";
    $first_time = true;
    if($first_time){
        $first_time = false;
        if(isset($_GET['id'])){
            include 'lib/koneksi.php';
            $cur_id = $_GET['id'];
            $sql = "CALL `get_seminar`($cur_id);";
            
            $data = mysqli_query($conn, $sql);
            if(mysqli_num_rows($data) > 0){
                while ($row = mysqli_fetch_assoc($data)):
                    $cur_id = $row['id'];
                    $judul = $row['judul'];
                    $keterangan = $row['keterangan'];
                    $waktu = date('Y-m-d\TH:i:s', strtotime($row['waktu']));
                endwhile;
            }else{
                $cur_id = 0;
            }
            $conn->close();
        }
    }

    if(isset($_POST['simpan'])){
        $judul = $_POST['judul'];
        $keterangan = $_POST['keterangan'];
        $waktu = $_POST['waktu'];
        
        $sql = "CALL `add_seminar`('$judul', '$keterangan', '$waktu', $cur_id);";

        include 'lib/koneksi.php';
        if(mysqli_query($conn, $sql)){
            echo "<script language=\"javascript\">window.location.href = 'seminar.php';</script>";
        }else{
            echo "<script language=\"javascript\">alert(\"Gagal simpan data seminar!\");</script>";
        }
        $conn->close();
    }
?>

<h1 class="text-center mt-3">Tambah/Edit Seminar</h1>

<div class="card ml-3 mr-3">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" required value="<?=$judul?>">
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea type="text" rows="4" class="form-control" id="keterangan" name="keterangan" required><?=$keterangan?></textarea>
            </div>
            <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="datetime-local" step="1" class="form-control" id="waktu" name="waktu" required value="<?=$waktu?>">
            </div>
            <button type="submit" class="btn btn-success" id="simpan" name="simpan" value="simpan">Simpan</button>
        </form>
    </div>
</div>

<?php 
    include_once 'lib/footer.php';
?>
