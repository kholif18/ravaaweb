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
  <!-- Navbar Glassmorphism -->
  <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <i class="fas fa-store me-2"></i>Ravaa Creative
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
              data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link active" href="<?= base_url() ?>">
              <i class="fas fa-home me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/shop') ?>">
              <i class="fas fa-shopping-bag me-1"></i> Shop
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/about') ?>">
              <i class="fas fa-info-circle me-1"></i> About
            </a>
          </li>
        </ul>
        
        <div class="d-flex align-items-center">
          <div class="search-container">
            <input type="text" class="search-box" placeholder="Cari produk...">
            <i class="fas fa-search position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); color: #666;"></i>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Add space for fixed navbar -->
  <div style="height: 80px;"></div>

  <main class="container-fluid p-0">
