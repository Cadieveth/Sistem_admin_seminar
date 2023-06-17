<?php
    session_start();
    if (!isset($_SESSION['uname'])){
        header("Location: login.php");
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

    <script src="lib/js/jquery.min.js"></script>

    <title>Sistem Manajemen Peserta Seminar</title>
  </head>
  <body>
      <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #301934;">
      <a class="navbar-brand pull-left" href="#">SMPS Admin</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
          <li class="nav-item">
              <a class="nav-link" href="index.php" id="dashboard">Dashboard</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="peserta.php" id="peserta">Peserta</a>
          </li>
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="data" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Seminar
              </a>
              <div class="dropdown-menu" aria-labelledby="data">
                  <a class="dropdown-item" id="seminar" href="seminar.php">Data Seminar</a>
                  <a class="dropdown-item" id="peserta_seminar" href="peserta_seminar.php">Peserta Seminar</a>
              </div>
          </li>
          </ul>
          <a href="logout.php" class="btn btn-secondary mr-2 my-2 my-sm-0" type="submit">Logout</a>
      </div>
      </nav>
      <div class="container-fluid">
