<?php include_once 'lib/header.php';?>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
    <a href="detail_peserta.php" class="btn btn-success ml-auto">Peserta Baru</a>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Peserta
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md" id="tabel">
            <thead class="thead-dark">
                <th scope="col">Email</th>
                <th scope="col">Nama</th>
                <th scope="col">No HP</th>
                <th scope="col">Gambar</th>
                <th scope="col">Menu</th>
            </thead>
            <tbody>
                <?php
                    include_once 'lib/koneksi.php';

                    $sql = "CALL `get_peserta`('', '');";

                    $data = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['email']?></td>
                    <td><?=$row['nama']?></td>
                    <td><?=$row['nohp']?></td>
                    <td><img src="<?=$row['gambar']?>" style="max-height: 100px; max-width: 300px;"></td>
                    <td>
                        <a href="detail_peserta.php?id=<?=$row['email']?>" class="btn btn-primary">Edit</a>
                        <a href="delete_peserta.php?id=<?=$row['email']?>" class="btn btn-danger">Hapus</a>
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

    var element = document.getElementById("peserta");
    element.classList.add("active");
</script>

<script src="lib/js/jquery.dataTables.min.js"></script>
<script src="lib/js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
    $conn->close();
?>
