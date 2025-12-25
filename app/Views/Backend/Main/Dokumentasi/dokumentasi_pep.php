<div class="col-md-10 main-content">
  <div class="bg-blur"></div>
  <div class="position-relative p-4">
    <div class="d-flex flex-column">
      <div class="p-2">
        <i class="bi bi-collection-play text-decoration-none" style="color: #000;"> / Dokumentasi Kegiatan</i>
      </div>

      <div class="p-2 d-flex justify-content-between align-items-center">
        <h2 style="color: #000;">Galeri Dokumentasi</h2>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
          <i class="bi bi-cloud-arrow-up"></i> Upload
        </button>
      </div>

      <hr>

      <div class="row">
        <?php if (!empty($data_user)): ?>
          <?php foreach ($data_user as $data):
            // ambil id file google drive dari kolom thumbnail
        
            $id = getDriveFileId($data['thumbnail']);
            $viewLink = $id ? "https://drive.google.com/uc?export=view&id={$id}" : base_url('Assets/img/noimage.png');
            $ext = strtolower(trim($data['ekstensi'] ?? ''));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'jfif']);
            $isVideo = in_array($ext, ['mp4', 'mkv']);
            $isPdf = ($ext === 'pdf');
            ?>
            <div class="col-md-4 mb-4">
              <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                  <h6><?= esc($data['nama_kegiatan']); ?></h6>
                  <?php if ($isImage): ?>
                    <img src="<?= base_url('image/' . $id); ?>" alt="Thumbnail" class="img-fluid rounded mb-2"
                      style="max-height:200px;">
                  <?php elseif ($isVideo): ?>
                    <video controls class="w-100 rounded mb-2" style="max-height:200px;">
                      <source src="<?= $viewLink; ?>" type="video/mp4">
                    </video>
                  <?php elseif ($isPdf): ?>
                    <div class="p-3 border rounded mb-2 bg-light text-center">
                      <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
                      <a href="<?= $viewLink; ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat PDF</a>
                    </div>
                  <?php else: ?>
                    <div class="p-3 border rounded mb-2 bg-light text-center">
                      <i class="bi bi-file-earmark text-secondary fs-1"></i>
                      <p class="small mb-0">File tidak dikenali</p>
                    </div>
                  <?php endif; ?>

                  <p class="text-muted small"><?= esc($data['keterangan']); ?></p>
                  <p class="text-muted small"><?= esc($data['tanggal_kegiatan']); ?></p>

                  <div class="d-flex justify-content-center gap-2">
                    <!-- 🔹 Tombol Detail -->
                    <a href="<?= base_url('/admin/dokumentasi/detail/' . $data['id_kegiatan']); ?>"
                      class="btn btn-sm btn-info">
                      <i class="bi bi-eye"></i> Detail
                    </a>

                    <button type="button" class="btn btn-sm btn-warning btnEditDoc" data-id="<?= $data['id_kegiatan']; ?>"
                      data-nama="<?= esc($data['nama_kegiatan']); ?>" data-ket="<?= esc($data['keterangan']); ?>">
                      <i class="bi bi-pencil"></i> Edit
                    </button>

                    <a href="<?= base_url('/admin/dokumentasi/hapus/' . sha1($data['id_kegiatan'])); ?>"
                      onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-sm btn-danger">
                      <i class="bi bi-trash"></i> Hapus
                    </a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center text-muted mt-5">Belum ada dokumentasi kegiatan.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal Upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="<?= base_url('admin/dokumentasi/simpan'); ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title"><i class="bi bi-upload"></i> Upload Dokumentasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label class="form-label">Nama Kegiatan</label>
              <input type="text" name="nama_kegiatan" class="form-control mb-3" required>

              <label class="form-label">Keterangan</label>
              <input type="text" name="keterangan" class="form-control mb-3">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Kegiatan</label>
              <input type="date" name="tanggal" class="form-control mb-3" required>

              <label class="form-label">Upload Gambar/Video/PDF (bisa banyak)</label>
              <input type="file" name="thumbnail[]" id="uploadInput" class="form-control" multiple
                accept=".jpg,.jpeg,.png,.jfif,.mp4,.mkv,.pdf" required>
              <small class="text-muted">Hanya file gambar, video, dan PDF yang diperbolehkan.</small>

            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Upload</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal Edit Dokumentasi -->
<div class="modal fade" id="editDocModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editDocForm">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Dokumentasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id_kegiatan" id="editDocId">

          <div class="mb-3">
            <label class="form-label">Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" id="editDocNama" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="keterangan" id="editDocKet" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
  document.getElementById('uploadInput').addEventListener('change', function () {
    const allowed = ['jpg', 'jpeg', 'png', 'jfif', 'mp4', 'mkv', 'pdf'];
    const files = this.files;
    let invalidFiles = [];

    for (let file of files) {
      const ext = file.name.split('.').pop().toLowerCase();
      if (!allowed.includes(ext)) {
        invalidFiles.push(file.name);
      }
    }

    if (invalidFiles.length > 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Format Tidak Diizinkan!',
        html: `
        <p>File berikut tidak diizinkan:</p>
        <ul style="text-align:left;">${invalidFiles.map(f => `<li>${f}</li>`).join('')}</ul>
        <p>Hanya upload gambar (jpg, png, jfif), video (mp4, mkv), dan PDF saja.</p>
      `,
        confirmButtonText: 'OK'
      });
      this.value = ''; // reset input agar tidak terkirim
    }
  });
</script>

<script>
  $(document).ready(function () {
    // 🔸 Buka modal edit
    $('.btnEditDoc').on('click', function () {
      $('#editDocId').val($(this).data('id'));
      $('#editDocNama').val($(this).data('nama'));
      $('#editDocKet').val($(this).data('ket'));
      $('#editDocModal').modal('show');
    });

    // 🔸 Proses submit form edit
    $('#editDocForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: "<?= base_url('admin/dokumentasi/edit'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
          Swal.fire({
            title: 'Menyimpan perubahan...',
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
          Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
        }
      });
    });
  });
</script>
<script>$('#formUpload').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function (e) {
          if (e.lengthComputable) {
            var percent = Math.round((e.loaded / e.total) * 100);
            $('#progress-bar').css('width', percent + '%').text(percent + '%');
          }
        });
        return xhr;
      },
      type: 'POST',
      url: '<?= base_url('/admin/dokumentasi/simpan'); ?>',
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#progress-container').show();
        $('#progress-bar').css('width', '0%').text('0%');
      },
      success: function () {
        Swal.fire('Sukses', 'Upload selesai!', 'success').then(() => location.reload());
      },
      error: function () {
        Swal.fire('Error', 'Terjadi kesalahan!', 'error');
      }
    });
  });
</script>
<style>
  .main-content {
    position: relative;
    min-height: 100vh;
    background: url('/Assets/img/bg.jpg') no-repeat center center fixed;
    background-size: cover;
  }

  .bg-blur {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    z-index: 1;
  }

  .main-content>.position-relative {
    z-index: 2;
  }

  .card {
    transition: 0.2s;
  }

  .card:hover {
    transform: scale(1.02);
  }
</style>