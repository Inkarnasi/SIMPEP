<div class="container mt-4">
  <a href="<?= base_url('/admin/dokumentasi'); ?>" class="btn btn-sm btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>

  <h4><?= esc($kegiatan['nama_kegiatan']); ?></h4>
  <p><strong>Tanggal:</strong> <?= esc($kegiatan['tanggal_kegiatan']); ?></p>
  <p><strong>Keterangan:</strong> <?= esc($kegiatan['keterangan']); ?></p>

  <div class="row">
    <?php foreach ($files as $f): ?>
      <?php 
        $id = getDriveFileId($f['file_url']);
        $ext = strtolower($f['ekstensi']);
        $view = getDriveViewLink($f['file_url']);
      ?>
      <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm">
          <?php if (in_array($ext, ['jpg','jpeg','png','jfif'])): ?>
            <img src="<?= base_url('image/' . $id); ?>" alt="Thumbnail" class="img-fluid rounded mb-2"
                      >
          <?php elseif (in_array($ext, ['mp4','mkv'])): ?>
            <video controls class="w-100 rounded">
              <source src="<?= getDriveDownloadLink($f['file_url']); ?>" type="video/mp4">
            </video>
          <?php elseif ($ext === 'pdf'): ?>
            <div class="p-4 text-center">
              <i class="bi bi-file-earmark-pdf text-danger fs-1"></i>
              <a href="<?= $view; ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Lihat PDF</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
