<?php include_once 'lib/header.php';?>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
    <a href="ikut_seminar.php" class="btn btn-success ml-auto">Ikuti Seminar</a>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Peserta Seminar
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md" id="tabel">
            <thead class="thead-dark">
                <th scope="col">Id Seminar</th>
                <th scope="col">Judul Seminar</th>
                <th scope="col">Email Peserta</th>
                <th scope="col">Nama Peserta</th>
                <th scope="col">Hadir</th>
                <th scope="col">Menu</th>
            </thead>
            <tbody>
                <?php
                    include_once 'lib/koneksi.php';

                    $sql = "CALL `get_peserta_seminar`(0, '');";

                    $data = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['id_seminar']?></td>
                    <td><?=$row['judul']?></td>
                    <td><?=$row['email']?></td>
                    <td><?=$row['nama']?></td>
                    <td><?php
                        if(intval($row['hadir']) == "1"){
                            echo 'Ya';
                        }else{
                            echo 'Belum';
                        }
                    ?></td>
                    <td>
                        <a href="ubah_hadir.php?id_seminar=<?=$row['id_seminar']?>&email=<?=$row['email']?>" class="btn btn-outline-success">Peserta Hadir</a>
                        <a href="delete_peserta_seminar.php?id=<?=$row['id']?>" class="btn btn-outline-danger">Hapus</a>
                    </td>
                </tr>
                <?php endwhile;?>
            </tbody>
        </table> 
    </div>
</div>

<script>
    $(document).ready(function(){
        var table = $('#tabel').DataTable({});
    });

    var element = document.getElementById("peserta_seminar");
    element.classList.add("active");
</script>

<script src="lib/js/jquery.dataTables.min.js"></script>
<script src="lib/js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
    $conn->close();
?>
