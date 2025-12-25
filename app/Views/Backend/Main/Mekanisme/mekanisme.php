<div class="container mt-4">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow-sm p-2 rounded">
      <li class="breadcrumb-item">
        <a href="<?= base_url('admin/mekanisme'); ?>">Mekanisme</a>
      </li>
      <?php foreach ($breadcrumb as $crumb): ?>
        <li class="breadcrumb-item">
          <a href="<?= base_url('admin/mekanisme/' . $crumb['id_folder_mek']); ?>"><?= esc($crumb['nama_folder_mek']); ?></a>
        </li>
      <?php endforeach; ?>
    </ol>
  </nav>

  <!-- Tombol aksi -->
  <div class="d-flex justify-content-between mb-3">
    <h5><i class="bi-folder-fill text-warning"></i> <?= esc($current_folder); ?></h5>
    <div>
      <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addFolderModal">
        <i class="bi bi-folder-plus"></i> Tambah Folder
      </button>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFileModal">
        <i class="bi bi-file-earmark-plus"></i> Tambah File
      </button>
        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#addLinkModal">
    <i class="bi bi-link-45deg"></i> Tambah Link
  </button>
    </div>
  </div>
  <div class="input-group mb-3">
    <input type="text" id="globalSearch" class="form-control" placeholder="🔍 Cari folder atau file...">
  </div>

  <!-- Tabel folder & file -->
  <form id="multiActionForm">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <div>
        <button type="button" id="btnDownloadSelected" class="btn btn-success btn-sm me-2">
          <i class="bi bi-download"></i> Download Terpilih
        </button>
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
              <th>No</th>
              <th>Nama</th>
              <th>Pemilik</th>
              <th>Tanggal Dibuat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <?php $no = 1; ?>
          <tbody>
            <?php foreach ($folders as $folder): ?>
              <tr>
                <td></td>
                <td><?= $no++; ?></td>
                <td>
                  <i class="bi-folder-fill text-warning"></i>
                  <a href="<?= base_url('admin/mekanisme/' . $folder['id_folder_mek']); ?>" class="ms-2 text-decoration-none"><?= esc($folder['nama_folder_mek']); ?></a>
                </td>
                <td><?= esc($folder['pemilik']); ?></td>
                <td><?= esc($folder['created']); ?></td>
                <td>                   <button type="button" class="btn btn-sm btn-warning btnEditFolder"
                    data-id="<?= $folder['id_folder_mek']; ?>" data-nama="<?= esc($folder['nama_folder_mek']); ?>">
                    <i class="bi bi-pencil"></i> Edit
                  </button><a href="<?= base_url('/admin/mekanisme/hapus_folder/' . sha1($folder['id_folder_mek'])); ?>"
                    onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                    Hapus
                  </a></td>
              </tr>
            <?php endforeach; ?>

            <?php foreach ($files as $file): ?>
              <tr>
                <td><input type="checkbox" name="selected_files[]" value="<?= esc($file['id_mekanisme']); ?>"></td>
                <td><?= $no++; ?></td>
                <td>
                  <i class="bi-file-earmark-text text-secondary"></i>
                  <?php
                  preg_match('/[-\w]{25,}/', $file['link'], $match);
                  $fileId = $match[0] ?? null;
                  $downloadUrl = $fileId ? "https://drive.google.com/uc?export=download&id={$fileId}" : '#';
                  ?>
                  <a href="<?= $downloadUrl; ?>" class="ms-2" download><?= esc($file['nama_file']); ?></a>
                </td>

                <td><?= esc($file['pemilik']); ?></td>
                <td><?= esc($file['created']); ?></td>
                <td><button type="button" class="btn btn-sm btn-warning btnEditFile"
                    data-id="<?= $file['id_mekanisme']; ?>" data-nama="<?= esc($file['nama_file']); ?>">
                    <i class="bi bi-pencil"></i> Edit
                  </button>
                  <a href="<?= base_url('/admin/mekanisme/hapus/' . sha1($file['id_mekanisme'])); ?>"
                    onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                    Hapus
                  </a>
                  <a href="<?= esc($file['link']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">
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




<!-- Modal Tambah Folder -->
<div class="modal fade" id="addFolderModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('admin/mekanisme/addFolder'); ?>">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Tambah Folder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_parent" value="<?= esc($id_parent); ?>">
          <input type="hidden" name="pemilik" value="<?= session()->get('ses_user'); ?>">
          <div class="mb-3">
            <label>Nama Folder</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah File -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="uploadForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah File</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="pemilik" value="<?= session()->get('ses_user'); ?>">
          <input type="hidden" name="folder_id" value="<?= esc($id_parent); ?>">

          <div class="mb-3">
            <label class="form-label">Pilih File</label>
            <input type="file" name="file[]" id="file" class="form-control" multiple required>
          </div>

          <div id="uploadStatus" class="text-center mt-2"></div>
        </div>

        <div class="modal-footer">
          <button type="button" id="cancelBtn" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="uploadBtn" class="btn btn-primary">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal Tambah Link -->
<div class="modal fade" id="addLinkModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addLinkForm" method="post">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="bi bi-link-45deg"></i> Tambah Link</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="pemilik" value="<?= session()->get('ses_user'); ?>">
          <input type="hidden" name="folder_id" value="<?= esc($id_parent); ?>">

          <div class="mb-3">
            <label class="form-label">Nama File / Dokumen</label>
            <input type="text" name="nama_file" class="form-control" placeholder="Masukkan nama dokumen" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Link Google Drive</label>
            <input type="url" name="link" class="form-control" placeholder="https://drive.google.com/..." required>
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
          <input type="hidden" name="tipe" id="editTipe"> <!-- file atau folder -->
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
<script>
$('#addLinkForm').on('submit', function(e) {
  e.preventDefault();

  $.ajax({
    url: "<?= base_url('admin/mekanisme/addLink'); ?>",
    type: "POST",
    data: $(this).serialize(),
    dataType: "json",
    beforeSend: function() {
      Swal.fire({
        title: 'Menyimpan link...',
        text: 'Mohon tunggu sebentar.',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
      });
    },
    success: function(res) {
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
    error: function() {
      Swal.close();
      Swal.fire('Error', 'Gagal menyimpan link.', 'error');
    }
  });
});
</script>

<script>
  // ✅ Centang semua file
  $('#selectAll').on('change', function() {
    $('input[name="selected_files[]"]').prop('checked', this.checked);
  });

  // ✅ Tombol Download Terpilih
  $('#btnDownloadSelected').on('click', function() {
    const selected = $('input[name="selected_files[]"]:checked')
      .map(function() {
        return $(this).val();
      }).get();

    if (selected.length === 0) {
      Swal.fire('Peringatan', 'Pilih minimal 1 file untuk diunduh!', 'warning');
      return;
    }

    Swal.fire({
      title: 'Menyiapkan file...',
      text: 'Mohon tunggu sebentar.',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    $.ajax({
      url: "<?= base_url('admin/mekanisme/downloadSelected'); ?>",
      type: "POST",
      data: {
        selected_files: selected
      },
      xhrFields: {
        responseType: 'blob'
      },
      success: function(blob, status, xhr) {
        Swal.close();

        const disposition = xhr.getResponseHeader('Content-Disposition');
        const filename = disposition && disposition.match(/filename="(.+)"/)[1] || 'download.zip';

        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = filename;
        link.click();
      },
      error: function() {
        Swal.fire('Error', 'Gagal memproses permintaan.', 'error');
      }
    });
  });

  // ✅ Tombol Hapus Terpilih (dengan alert proses)
  $('#btnDeleteSelected').on('click', function() {
    const selected = $('input[name="selected_files[]"]:checked')
      .map(function() {
        return $(this).val();
      }).get();

    if (selected.length === 0) {
      Swal.fire('Peringatan', 'Pilih minimal 1 file untuk dihapus!', 'warning');
      return;
    }

    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "File yang dihapus tidak bisa dikembalikan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {

        // 🔹 Tampilkan alert loading saat proses hapus berjalan
        Swal.fire({
          title: 'Menghapus file...',
          text: 'Mohon tunggu, sedang memproses penghapusan.',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });

        $.ajax({
          url: "<?= base_url('admin/mekanisme/deleteSelectedFiles'); ?>",
          type: "POST",
          dataType: "json",
          data: {
            ids: selected
          },
          success: function(res) {
            Swal.close();
            if (res.status === 'success') {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
              });
              setTimeout(() => location.reload(), 1200);
            } else {
              Swal.fire('Gagal', res.message, 'error');
            }
          },
          error: function() {
            Swal.close();
            Swal.fire('Error', 'Gagal memproses permintaan.', 'error');
          }
        });
      }
    });
  });
</script>


<script>
  document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const files = document.getElementById('file').files;
    if (files.length === 0) {
      alert("Silakan pilih file!");
      return;
    }

    // Sembunyikan tombol saat upload berjalan
    document.getElementById('cancelBtn').style.display = 'none';
    document.getElementById('uploadBtn').style.display = 'none';

    uploadSequential(files);
  });

  async function uploadSequential(files) {
    const totalFiles = files.length;
    const progressContainer = document.getElementById('uploadStatus');
    progressContainer.innerHTML = '';

    for (let i = 0; i < totalFiles; i++) {
      const file = files[i];
      const formData = new FormData();
      formData.append('file[]', file);
      formData.append('folder_id', document.querySelector('[name="folder_id"]').value);
      formData.append('pemilik', document.querySelector('[name="pemilik"]').value);

      // Buat tampilan progress per file
      const wrapper = document.createElement('div');
      wrapper.classList.add('mt-3');
      wrapper.innerHTML = `
      <div class="small fw-bold">${file.name}</div>
      <div class="progress" style="height: 22px;">
        <div id="progress-${i}" class="progress-bar progress-bar-striped progress-bar-animated bg-info" 
             style="width: 0%">0%</div>
      </div>
      <small id="info-${i}" class="text-muted"></small>
    `;
      progressContainer.appendChild(wrapper);

      // Upload satu per satu
      await new Promise((resolve) => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url('admin/mekanisme/addFile'); ?>', true);

        const startTime = Date.now();
        xhr.upload.addEventListener('progress', (e) => {
          if (e.lengthComputable) {
            const percent = Math.round((e.loaded / e.total) * 100);
            const uploadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
            const totalMB = (e.total / (1024 * 1024)).toFixed(2);

            const elapsedTime = (Date.now() - startTime) / 1000;
            const speed = (e.loaded / 1024 / elapsedTime).toFixed(1);
            const remainingTime = ((e.total - e.loaded) / 1024) / speed;
            const timeDisplay = remainingTime < 60 ?
              `${Math.round(remainingTime)}s tersisa` :
              `${Math.floor(remainingTime / 60)}m ${Math.round(remainingTime % 60)}s tersisa`;

            const bar = document.getElementById(`progress-${i}`);
            const info = document.getElementById(`info-${i}`);

            bar.style.width = percent + '%';
            bar.textContent = percent + '%';
            info.textContent = `📤 ${uploadedMB}/${totalMB} MB — ${speed} KB/s — ${timeDisplay}`;
          }
        });

        xhr.onload = () => {
          const bar = document.getElementById(`progress-${i}`);
          const info = document.getElementById(`info-${i}`);
          if (xhr.status === 200) {
            try {
              const res = JSON.parse(xhr.responseText);
              if (res.status === 'success') {
                bar.classList.replace('bg-info', 'bg-success');
                bar.textContent = '✅ Selesai';
                info.textContent = `✔️ ${file.name} berhasil diunggah`;
              } else {
                bar.classList.replace('bg-info', 'bg-danger');
                bar.textContent = '❌ Gagal';
                info.textContent = `Gagal: ${res.message}`;
              }
            } catch {
              bar.classList.replace('bg-info', 'bg-danger');
              bar.textContent = '⚠️ Error Respon';
            }
          } else {
            bar.classList.replace('bg-info', 'bg-danger');
            bar.textContent = '⚠️ Error Server';
          }
          resolve();
        };

        xhr.onerror = () => {
          const bar = document.getElementById(`progress-${i}`);
          bar.classList.replace('bg-info', 'bg-danger');
          bar.textContent = 'Koneksi Error';
          resolve();
        };

        xhr.send(formData);
      });
    }

    // Tampilkan tombol lagi setelah semua upload selesai
    document.getElementById('cancelBtn').style.display = 'inline-block';
    document.getElementById('uploadBtn').style.display = 'inline-block';

    setTimeout(() => location.reload(), 1500);
  }
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
  $(document).ready(function() {
    console.log("✅ jQuery dan DataTables aktif");

    $('#fileTable').DataTable({
      "pageLength": 10,
      "lengthMenu": [5, 10, 25, 50, 100],
      "ordering": true,
      "searching": false,
      "language": {
        "lengthMenu": "Tampilkan _MENU_ file per halaman",
        "zeroRecords": "Tidak ada file ditemukan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ file",
        "infoEmpty": "Tidak ada file",
        "infoFiltered": "(difilter dari total _MAX_ file)",
      }
    });
  });
</script>
<script>
  $(document).ready(function() {
    $('#globalSearch').on('keyup', function() {
      let keyword = $(this).val().trim();

      if (keyword.length < 1) return; // minimal 1 huruf baru cari

      $.ajax({
        url: '<?= base_url('admin/mekanisme/search'); ?>',
        method: 'POST',
        data: {
          keyword: keyword
        },
        dataType: 'json',
        success: function(res) {
          let tableBody = $('#fileTable tbody');
          tableBody.empty(); // kosongkan isi tabel

          // tampilkan folder hasil pencarian
          res.folders.forEach(folder => {
            tableBody.append(`
            <tr>
              <td><i class="bi-folder-fill text-warning"></i> 
                  <a href="<?= base_url('admin/mekanisme/'); ?>${folder.id_folder_mek}" 
                     class="ms-2 text-decoration-none">${folder.nama_folder_mek}</a></td>
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
              <td class="text-end">
                <a href="${file.link}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi-eye"></i></a>
              </td>
            </tr>
          `);
          });
        },
        error: function() {
          console.error('❌ Gagal memuat hasil pencarian');
        }
      });
    });
  });
</script>
<script>
  $(document).ready(function () {
    // 🔹 Tombol edit folder
    $('.btnEditFolder').on('click', function () {
      $('#editTipe').val('folder');
      $('#editId').val($(this).data('id'));
      $('#editNama').val($(this).data('nama'));
      $('#editModal').modal('show');
    });

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
        url: "<?= base_url('admin/mekanisme/editItem'); ?>",
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