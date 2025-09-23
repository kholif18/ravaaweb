<?= $this->include('backend/layouts/header') ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 bg-light sidebar p-3 vh-100">
      <?= $this->include('backend/layouts/sidebar') ?>
    </div>

    <!-- Content -->
    <div class="col-md-10 p-4 content">
      <?= $content ?? '' ?>
    </div>
  </div>
</div>

<?= $this->include('backend/layouts/footer') ?>
