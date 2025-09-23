<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - <?= $title ?? 'Dashboard' ?></title>
  <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/all.min.css') ?>" rel="stylesheet"> <!-- FontAwesome -->
  <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet"> <!-- custom -->
</head>
<body>
  <nav class="navbar navbar-dark bg-dark p-2">
    <a class="navbar-brand ms-3" href="<?= base_url('admin/dashboard') ?>">
      <i class="fas fa-cogs me-2"></i> Admin Panel
    </a>
    <div class="d-flex me-3">
      <a href="#" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
