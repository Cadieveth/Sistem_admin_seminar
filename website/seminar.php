<?php include_once 'lib/header.php';?>

<div class="mb-2 mt-4 ml-2 mr-2 col row">
    <a href="detail_seminar.php" class="btn btn-success ml-auto">Seminar Baru</a>
</div>

<div class="card" style="margin: 2rem;">
    <div class="card-header">
        Daftar Seminar
    </div>
    <div class="card-body">
        <table class="table table-bordered table-responsive-md" id="tabel">
            <thead class="thead-dark">
                <th scope="col">ID</th>
                <th scope="col">Judul</th>
                <th scope="col">Waktu</th>
                <th scope="col">Menu</th>
            </thead>
            <tbody>
                <?php
                    include_once 'lib/koneksi.php';

                    $sql = "CALL `get_seminar`(0);";

                    $data = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($data)):
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['judul']?></td>
                    <td><?=$row['waktu']?></td>
                    <td>
                        <a href="detail_seminar.php?id=<?=$row['id']?>" class="btn btn-primary">Edit</a>
                        <a href="delete_seminar.php?id=<?=$row['id']?>" class="btn btn-danger">Hapus</a>
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

    var element = document.getElementById("seminar");
    element.classList.add("active");
</script>

<script src="lib/js/jquery.dataTables.min.js"></script>
<script src="lib/js/dataTables.bootstrap4.min.js"></script>

<?php include_once 'lib/footer.php';
    $conn->close();
?>
