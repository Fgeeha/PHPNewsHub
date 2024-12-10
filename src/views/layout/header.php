<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> News PHP </title>
  
  <link rel="icon" type="image/x-icon" href="<?php __DIR__ ?>/public/assets/images/favicon.png">

  <!-- custom css link -->
  <link rel="stylesheet" href="<?php __DIR__ ?>/public/assets/bootstrap5/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php __DIR__ ?>/public/assets/css/styles.css">

  <!-- google font link -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Monoton&family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <script src="<?php __DIR__ ?>/public/assets/bootstrap5/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <!-- main container -->
  <div class="container">
      <!-- #HEADER -->
    <header>
      <!-- #NAVBAR -->
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">
            <img src="<?php __DIR__ ?>/public/assets/images/logo.svg" alt="logo" class="footer-brand" width="75">
            <span>News Demo</span>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link <?php if ($page == 'news') {
                    echo 'active';
                } ?> " href="/news">Новости</a>
              </li>
              <li class="nav-item">
                <a class="nav-link  <?php if ($page == 'add-news') {
                    echo 'active';
                } ?> " href="/add-news">Создать новость</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
    <main>