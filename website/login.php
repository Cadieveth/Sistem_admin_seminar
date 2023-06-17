<?php
    session_start();
    if (isset($_SESSION['uname'])){
        header("Location: index.php");
        exit;
    }
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="lib/css/bootstrap.min.css">

    <title>Sistem Manajemen Peserta Seminar</title>
  </head>
  <body style="background-color: #301934;">
    <div class="container-fluid">

<?php
    include_once "lib/koneksi.php";
    if(isset($_POST['login'])){
        $uname = $_POST['uname'];
        $pass = $_POST['pass'];

        $hashed_pass = hash("sha512", $pass);

        $sql = "CALL `get_admin`('$uname', '$hashed_pass');";

        $data = mysqli_query($conn, $sql);
        $total_row = mysqli_num_rows($data);
        $akun_ada = false;
        
        if($total_row > 0){
            $akun_ada = true;
        }

        if($akun_ada){
            $_SESSION['uname'] = $uname;
            $_SESSION['pass'] = $hashed_pass;
            if(isset($_POST['remember'])){
                setcookie('save_uname', $uname, time() + (86400 * 30), "/");
                setcookie('save_pass', $pass, time() + (86400 * 30), "/");
            }else{
                clear_cookie('save_uname');
                clear_cookie('save_pass');
            }
            echo "<script language=\"javascript\">window.location.href = 'index.php';</script>";
        }else{
            clear_cookie('save_uname');
            clear_cookie('save_pass');
            echo "<script language=\"javascript\">alert(\"Username atau password salah atau tidak terdaftar!\");</script>";
        }
    }

    function clear_cookie($cookie_name){
        if(isset($_COOKIE[$cookie_name])){
            unset($_COOKIE[$cookie_name]);
            setcookie($cookie_name, null, -1, '/');
        }
    }
    $conn->close();
?>


<div class="col">
    <h3 class="text-center mt-3" style="color:white;">Sistem Manajemen Peserta Seminar</h3>
    <h1 class="text-center mt-5" style="color:white;">Login Admin</h1>

    <div class="row justify-content-center" style="margin-top: 3rem;">
    <div class="card" style="width: 20rem;">
        <div class="card-body">
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" id="uname" name="uname" required>
            </div>
            <div class="form-group">
                <label for="pass">Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="checked">
                <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>
            <button type="submit" class="btn btn-primary" id="login" name="login" value="login">Login</button>
        </form>
        </div>
    </div>
    </div>
</div>

<script>
    var cond = <?php if(isset($_COOKIE['save_uname']) && isset($_COOKIE['save_pass'])){echo 1;}else{echo 0;}?>;
    if(cond == 1){
        document.getElementById("remember").checked = true;
        document.getElementById("uname").value = '<?php if(isset($_COOKIE['save_uname'])) echo $_COOKIE['save_uname'];?>';
        document.getElementById("pass").value = '<?php if(isset($_COOKIE['save_pass'])) echo $_COOKIE['save_pass'];?>';
    }
</script>


</div>
<script src="lib/js/jquery.min.js"></script>
<script src="lib/js/popper.min.js"></script>
<script src="lib/js/bootstrap.min.js"></script>
</body>
</html>
