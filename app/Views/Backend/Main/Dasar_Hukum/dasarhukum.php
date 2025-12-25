<div class="container mt-4">

  <!-- Tombol aksi -->
  <div class="d-flex justify-content-between mb-3">
    <h5><i class="bi-folder-fill text-warning"></i> <?= esc($current_folder); ?></h5>
    <div>
      <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#addHukumModal">
        <i class="bi bi-link-45deg"></i> Tambah Hukum
      </button>
    </div>
  </div>
  <div class="input-group mb-3">
    <input type="text" id="globalSearch" class="form-control" placeholder="🔍 Cari hukum...">
  </div>

  <!-- Tabel Hukum -->
  <form id="multiActionForm">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div>
        <button type="button" id="btnDeleteSelected" class="btn btn-danger btn-sm">
          <i class="bi bi-trash"></i> Hapus Terpilih
        </button>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body p-3">
        <table id="fileTable" class="table table-striped">
          <thead class="table-light">
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
              <th>Nama</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($files as $file): ?>
              <tr>
                <td><input type="checkbox" name="selected_files[]" value="<?= esc($file['id_hukum']); ?>"></td>
                <td>
                  <span class="ms-0"><?= esc($file['nama_hukum']); ?></span>
                </td>

                <td> <button type="button" class="btn btn-sm btn-warning btnEditFile" data-id="<?= $file['id_hukum']; ?>"
                    data-nama="<?= esc($file['nama_hukum']); ?>">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                  <a href="<?= base_url('/admin/dasarhukum/hapus/' . sha1($file['id_hukum'])); ?>"
                    onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                    Hapus
                  </a>
                  <i class="bi-eye"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </form>
</div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Nama</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editId">

          <div class="mb-3">
            <label class="form-label">Nama Baru</label>
            <input type="text" class="form-control" name="nama" id="editNama" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Dasar Hukum -->
<div class="modal fade" id="addHukumModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addHukumForm" method="post">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="bi bi-link-45deg"></i> Tambah Hukum</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="pemilik" value="<?= session()->get('ses_user'); ?>">

          <div class="mb-3">
            <label class="form-label">Isi Hukum</label>
            <input type="text" name="nama_hukum" class="form-control" placeholder="Masukkan Isi Hukum" required>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  $(document).ready(function () {
    // 🔹 Tombol edit file
    $('.btnEditFile').on('click', function () {
      $('#editTipe').val('file');
      $('#editId').val($(this).data('id'));
      $('#editNama').val($(this).data('nama'));
      $('#editModal').modal('show');
    });

    // 🔹 Submit form edit
    $('#editForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: "<?= base_url('admin/dasarhukum/editItem'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
          Swal.fire({
            title: 'Menyimpan perubahan...',
            text: 'Mohon tunggu sebentar.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
          });
        },
        success: function (res) {
          Swal.close();
          if (res.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: res.message,
              timer: 1200,
              showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1200);
          } else {
            Swal.fire('Gagal', res.message, 'error');
          }
        },
        error: function () {
          Swal.close();
          Swal.fire('Error', 'Terjadi kesalahan saat menyimpan.', 'error');
        }
      });
    });
  });
</script>

<script>
  $('#addHukumForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: "<?= base_url('admin/dasarhukum/addHukum'); ?>",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      beforeSend: function () {
        Swal.fire({
          title: 'Menyimpan hukum...',
          text: 'Mohon tunggu sebentar.',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
      },
      success: function (res) {
        Swal.close();
        if (res.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: res.message,
            timer: 1200,
            showConfirmButton: false
          });
          setTimeout(() => location.reload(), 1200);
        } else {
          Swal.fire('Gagal', res.message, 'error');
        }
      },
      error: function () {
        Swal.close();
        Swal.fire('Error', 'Gagal menyimpan link.', 'error');
      }
    });
  });
</script>

<script>
  $(document).ready(function () {

    // ✅ Centang semua file
    $('#selectAll').on('change', function () {
      $('input[name="selected_files[]"]').prop('checked', this.checked);
    });

    // ✅ Tombol Hapus Terpilih
    $('#btnDeleteSelected').on('click', function () {
      const selected = $('input[name="selected_files[]"]:checked')
        .map(function () {
          return $(this).val();
        }).get();

      if (selected.length === 0) {
        Swal.fire('Peringatan', 'Pilih minimal 1 file untuk dihapus!', 'warning');
        return;
      }

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Hukum yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {

          // 🔹 Tampilkan loading selama proses hapus
          Swal.fire({
            title: 'Menghapus data...',
            text: 'Mohon tunggu, sedang memproses penghapusan.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
          });

          $.ajax({
            url: "<?= base_url('admin/dasarhukum/deleteSelectedHukum'); ?>",
            type: "POST",
            dataType: "json",
            data: { ids: selected },
            success: function (res) {
              Swal.close();

              if (res.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: res.message,
                  timer: 1500,
                  showConfirmButton: false
                });

                setTimeout(() => {
                  location.reload();
                }, 1200);

              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: res.message
                });
              }
            },
            error: function (xhr, status, error) {
              Swal.close();
              Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Gagal memproses permintaan. Coba lagi nanti.'
              });
              console.error(error);
            }
          });
        }
      });
    });

  });
</script>


<!-- ========================================= -->
<!-- 1️⃣  jQuery WAJIB PALING ATAS -->


<!-- 2️⃣  Bootstrap Bundle -->


<!-- 3️⃣  DataTables CSS (pindahkan ke <head> kalau mau rapi, tapi ini juga aman di sini) -->
<link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- 4️⃣  DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<!-- 5️⃣  Inisialisasi DataTables -->
<script>
  $(document).ready(function () {
    console.log("✅ jQuery dan DataTables aktif");

    $('#fileTable').DataTable({
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      "ordering": true,
      "searching": false,
      "language": {
        "lengthMenu": "Tampilkan _MENU_ file per halaman",
        "zeroRecords": "Tidak ada hukum ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ file",
        "infoEmpty": "Tidak ada hukum",
        "infoFiltered": "(difilter dari total _MAX_ file)",
      }
    });
  });
</script>
<script>
  $(document).ready(function () {
    $('#globalSearch').on('keyup', function () {
      let keyword = $(this).val().trim();

      if (keyword.length < 1) return; // minimal 1 huruf baru cari

      $.ajax({
        url: '<?= base_url('admin/dasarhukum/search'); ?>',
        method: 'POST',
        data: {
          keyword: keyword
        },
        dataType: 'json',
        success: function (res) {
          let tableBody = $('#fileTable tbody');
          tableBody.empty(); // kosongkan isi tabel

          // tampilkan folder hasil pencarian
          res.folders.forEach(folder => {
            tableBody.append(`
            <tr>
              <td><i class="bi-folder-fill text-warning"></i> 
                  <a href="<?= base_url('admin/dasarhukum/'); ?>${folder.id_folder_das}" 
                     class="ms-2 text-decoration-none">${folder.nama_folder_das}</a></td>
              <td>${folder.pemilik}</td>
              <td>${folder.created}</td>
              <td></td>
            </tr>
          `);
          });

          // tampilkan file hasil pencarian
          res.files.forEach(file => {
            const fileId = file.link.match(/[-\w]{25,}/); // ambil fileId dari URL Google Drive
            const driveLink = `https://drive.google.com/uc?export=download&id=${fileId}`;

            tableBody.append(`
            <tr>
              <td><i class="bi-file-earmark-text text-secondary"></i> 
                  <a href="${driveLink}" target="_blank" class="ms-2 text-decoration-none">${file.nama_file}</a></td>
              <td>${file.pemilik}</td>
              <td>${file.created}</td>
            </tr>
          `);
          });
        },
        error: function () {
          console.error('❌ Gagal memuat hasil pencarian');
        }
      });
    });
  });
</script>

<style>
  body {
    margin: 0;
    min-height: 100vh;
    background: url('<?= base_url("/Assets/img/bg.jpg"); ?>') no-repeat center center fixed;
    background-size: cover;
    background-attachment: fixed;
    font-family: 'Poppins', sans-serif;
  }

  /* Supaya teks dan card tetap mudah dibaca di atas gambar */
  body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.75);
    /* atur tingkat transparansi */
    z-index: -1;
  }
</style>