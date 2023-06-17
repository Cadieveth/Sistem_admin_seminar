<?php include_once 'lib/header.php';

    $uname = $_SESSION['uname'];
  
    include_once 'lib/koneksi.php';

    $t_pes = 0; $t_sem = 0;

    $sql = "CALL `get_count_peserta_seminar`();";
    $data = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($data)){
        $t_pes = $row['peserta'];
        $t_sem = $row['seminar'];
    }

    $conn->close();
?>

<h1 class="mb-2 mt-4 text-center">Dashboard</h1>

<div class="row mt-3 mb-3">
  <div class="col card ml-3 mr-3">
      <div class="card-body justify-content-center">
        <h5 class="card-title">Data Peserta</h5>
        <p class="card-text" id="training_count"><?=$t_pes?></p>
        <a href="peserta.php" class="btn btn-outline-primary">Lihat</a>
      </div>
  </div>
  <div class="col card ml-3 mr-3">
      <div class="card-body justify-content-center">
        <h5 class="card-title">Data Seminar</h5>
        <p class="card-text" id="testing_count"><?=$t_sem?></p>
        <a href="seminar.php" class="btn btn-outline-primary">Lihat</a>
      </div>
  </div>
</div>
<script>
    var elem = document.getElementById("dashboard");
    elem.className += " active";
</script>
<?php
    include_once 'lib/footer.php';
?>
