<!-- Tombol Toggle Sidebar (di bawah navbar) -->
<div class="toggle-container bg-light py-2 px-3 d-lg-none" style="border-bottom: 1px solid ">
  <!-- Tombol Toggle Sidebar -->
  <button id="toggleSidebar" class="btn btn-light position-fixed top-5 start-0 m-2"
    style="z-index:2000; border-radius:50%; box-shadow:0 2px 5px rgba(0, 0, 0, 0.2);">
    ☰
  </button>
</div>

<div class="d-flex">
  <!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3 text-white">
  <!-- isi sidebar -->



    <ul class="list-group">
      <li class="list-group-item <?php if ($asal == 'beranda') {
                                    echo 'active';
                                  } ?>"> <a href="/admin/main" class="d-flex align-items-center text-decoration-none text-black"> <i class="bi bi-house me-2"></i> Beranda </a> </li>
      <li class="list-group-item <?php if ($asal == 'dasarhukum') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/dasarhukum " class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-book-half me-2"></i> Dasar Hukum
        </a>
      </li>
      <li class="list-group-item <?php if ($asal == 'mekanisme') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/mekanisme" class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-diagram-3 me-2"></i> Alur Mekanisme
        </a>
      </li>
      <li class="list-group-item <?php if ($asal == 'perencanaan') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/perencanaan" class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-journal-check me-2"></i> Perencanaan
        </a>
      </li>
      <li class="list-group-item <?php if ($asal == 'monitoring') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/monitoring" class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-gear me-2"></i> Monitoring Pelaporan
        </a>
      </li>
      <li class="list-group-item <?php if ($asal == 'dokumentasi') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/dokumentasi" class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-camera-reels-fill me-2"></i> Dokumentasi Kegiatan PEP
        </a>
      </li>
      <li class="list-group-item <?php if ($asal == 'penyimpanan') {
                                    echo 'active';
                                  } ?>">
        <a href="/admin/penyimpanan" class="d-flex align-items-center text-decoration-none text-black">
          <i class="bi bi-hdd-stack-fill me-2"></i> Penyimpanan
        </a>
      </li>
    </ul>
  </div>




  <!-- SCRIPT TOGGLE -->
  <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
    });

    
  </script>

<style>
  /* Warna default item */
  .list-group-item {
    background-color: #fff;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  /* Warna teks dan ikon default */
  .list-group-item a {
    color: #000; /* hitam */
  }

  /* Saat aktif, ubah jadi cyan */
  .list-group-item.active {
    background-color: #3f59ebff; /* cyan */
  }

</style>

  <!-- STYLE -->
  <style>
.sidebar {
    background: transparent; /* biarkan transparan agar efek body::before tembus */
    color: #fff;
    border-right: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: inset 0 0 0 rgba(0,0,0,0); /* hilangkan bayangan */
              width: 250px;
      min-height: 100vh;
                transition: transform 0.3s ease;
      z-index: 1000;
}


    /* Mobile: sidebar disembunyikan default */
    @media (max-width: 992px) {
      .sidebar {
        position: fixed;
        top: 60px;
        /* agar di bawah header dan tombol */
        left: 0;
        transform: translateX(-100%);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }
    }

    /* Desktop: sidebar selalu terlihat */
    @media (min-width: 992px) {
      .toggle-container {
        display: none;
      }
    }
  </style>