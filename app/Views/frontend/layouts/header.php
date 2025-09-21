<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $title ?? 'Toko Online' ?></title>

  <!-- Bootstrap 5 CSS -->
  <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?= base_url('assets/css/all.min.css') ?>" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/ravaa.css') ?>">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">TokoOnline</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-search"></i></a></li>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container-fluid p-0">
