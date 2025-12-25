<?php
if (session()->get('ses_id') == "" or session()->get('ses_user') == "") {
  ?>
  <script>
    alert("login expired, silahkan login ulang");
    document.location = "<?= base_url('admin/login'); ?>";
  </script>
  <?php
}
?>




<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN - PEP</title>

  <link rel="stylesheet" type="css" href="/Assets/css/all_manual.css">
  <link href="/Assets/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="/Assets/font/bootstrap-icons.css">
  <link href="/Assets/css/sweetalert2.min.css" rel="stylesheet">
<!-- DataTables CSS & JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap Bundle (sudah termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://apis.google.com/js/api.js"></script>


<!-- ===== NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container-fluid px-3">
    <!-- Logo dan Judul -->
    <a class="navbar-brand d-flex align-items-center" href="<?= base_url('admin/main'); ?>">
      <img src="/Assets/img/logo.png" alt="Logo PEP" style="height:40px; margin-right:10px;">
      <span class="d-none d-sm-inline">DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN - PEP</span>
      <span class="d-inline d-sm-none">DAMKAR - PEP</span>
    </a>

    <!-- Tombol Toggle (Mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Dropdown -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle bi-person" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <?= session()->get('ses_user'); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="dropdown-header text-center">
              <img src="/Assets/img/profil.jpg" alt="Profil"
                class="img-thumbnail rounded-circle mb-2" style="width: 60px; height: 60px;">
              <div class="fw-semibold text-dark"><?= session()->get('ses_user'); ?></div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= base_url('/admin/setting'); ?>">Settings</a></li>
            <li><a class="dropdown-item text-danger" href="<?= base_url('admin/logout'); ?>" id="logoutButton">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ===== CSS Tambahan ===== -->
<style>
/* ======== UNTUK MOBILE ======== */
@media (max-width: 992px) {
  .main-content {
    margin: 0 auto;            /* rata tengah */
    padding: 1rem;             /* padding lebih kecil */
    width: 95%;                /* isi layar tapi beri jarak kanan kiri */
    font-size: 0.95rem;        /* perkecil teks sedikit */
  }

  .card, .container, .content-box {
    width: 100%;
    border-radius: 10px;
    box-shadow: none;
  }

  h3, h4, h5 {
    font-size: 1.1rem;
    text-align: center;
  }

  p {
    text-align: justify;
    line-height: 1.5;
  }
}
  /* Navbar selalu full width */
  .navbar {
    width: 100vw;
    left: 0;
    right: 0;
    background: #0C1753;
    z-index: 1050;
  }

  /* Warna teks & hover */
  .navbar .nav-link {
    color: #D3D3D3 !important;
    font-weight: 500;
  }

  .navbar .nav-link:hover {
    color: #ffffff !important;
  }

  /* Untuk HP: teks kecil dan padding lebih rapat */
  @media (max-width: 767px) {
    .navbar {
      padding: 8px 10px;
    }

    .navbar-brand span {
      font-size: 14px;
    }

    .navbar .nav-link {
      text-align: center;
      padding: 10px 0;
      width: 100%;
    }

    .dropdown-menu {
      width: 100%;
      text-align: center;
    }
  }
</style>

  <style>
    .swal2-styled.swal2-cancel {
      margin-left: 100px !important;
      /* Mengubah jarak antara tombol */
    }
  </style>

</head>

<body>