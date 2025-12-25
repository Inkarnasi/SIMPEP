<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <link href="/Assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/Assets/font/bootstrap-icons.css">

  <style>
    body {
      cursor: url('/Assets/img/cursor.png'), auto;
      background-image: url('/Assets/img/bio.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center; /* membuat konten di tengah vertikal & horizontal */
    }

    .form-container {
      background: rgba(255, 255, 255, 0.85);
      border-radius: 15px;
      padding: 30px 40px;
      max-width: 600px;
      width: 100%;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .form-floating label {
      color: #000 !important;
    }

    .form-control {
      color: #000;
      background-color: rgba(255, 255, 255, 0.8);
      border: 1px solid rgba(0, 0, 0, 0.3);
    }

    .form-control:focus {
      background-color: #fff;
      border-color: #0d6efd;
      box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
    }

    .title {
      color: #444;
      text-align: center;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="form-container">
    <div class="text-center mb-3">
      <i class="bi-person-add" style="color: #808080;"> / Pendaftaran</i>
    </div>

    <h4 class="title">Akun Baru</h4>
    <hr>

    <?php if (session()->get('error_list') != ""): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->get('error_list'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form role="form" method="post" action="<?= base_url('/admin/daftar/simpan'); ?>">
      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" placeholder="Nama" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Username Untuk Login" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="pw" placeholder="Masukkan Password" required>
      </div>

      <div class="text-center">
        <button type="reset" class="btn btn-secondary me-2">Reset</button>
        <button class="btn btn-primary" type="submit">Submit</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.querySelector('form').addEventListener('submit', function (event) {
      Swal.fire({
        title: 'Loading',
        didOpen: () => Swal.showLoading()
      });
    });

    let hasil = '<?= session()->getFlashdata('hasil') ?>';
    if (hasil) {
      let title, text, icon;
      if (hasil === 'Berhasil') {
        title = 'Berhasil Daftar!';
        text = 'Silahkan Login';
        icon = 'success';
      } else {
        title = 'Daftar Gagal!';
        text = 'Username Sudah Ada';
        icon = 'error';
      }

      Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: 'OK'
      }).then(() => {
        if (hasil === 'Berhasil') {
          window.location.href = '/admin/login';
        }
      });
    }
  </script>
</body>
</html>
