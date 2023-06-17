<?php include_once 'lib/header.php';

    if(isset($_POST['simpan'])){
        $id_seminar = $_POST['judul'];
        $email = $_POST['email'];
        
        include 'lib/koneksi.php';
        $sql = "CALL `get_peserta_seminar`($id_seminar, '$email');";
        $data = mysqli_query($conn, $sql);
        $t_row = mysqli_num_rows($data);
        $conn->close();

        if($t_row == 0):
            include 'lib/koneksi.php';
            $sql = "CALL `add_peserta_seminar`($id_seminar, '$email', 0);";
            if(mysqli_query($conn, $sql)){
                echo "<script language=\"javascript\">window.location.href = 'peserta_seminar.php';</script>";
            }else{
                echo "<script language=\"javascript\">alert(\"Peserta gagal mengikuti seminar!\");</script>";
            }
            $conn->close();
        else:
            echo "<script language=\"javascript\">alert(\"Peserta dengan email $email sudah mengikuti seminar ini\");</script>";
        endif;
    }
?>

<h1 class="text-center mt-3">Tambah Data Ikut Seminar Baru</h1>

<div class="card ml-3 mr-3">
    <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">Email Peserta</label>
                <select class="form-control" id="email" name="email" required>
                    <option disabled selected value="">Pilih Email Peserta</option>
                    <?php
                        include 'lib/koneksi.php';

                        $sql = "CALL `get_peserta`('', '');";

                        $data = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data)):
                    ?>
                        <option value="<?=$row['email']?>"><?=$row['email']?></option>
                    <?php
                        endwhile;
                        $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="judul">Seminar</label>
                <select class="form-control" id="judul" name="judul" required>
                    <option disabled selected value="">Pilih Seminar</option>
                    <?php
                        include 'lib/koneksi.php';

                        $sql = "CALL `get_seminar`(0);";

                        $data = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($data)):
                    ?>
                        <option value=<?=$row['id']?>><?=$row['judul']?></option>
                    <?php
                        endwhile;
                        $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success" id="simpan" name="simpan" value="simpan">Simpan</button>
        </form>
    </div>
</div>

<?php 
    include_once 'lib/footer.php';
?>
