<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="/Assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/font/bootstrap-icons.css">

</head>
<style>
    .form-floating label {
        color: #000000ff !important;
        /* warna label */
    }

    .form-control {
        color: #fff;
        /* warna input teks */
        background-color: rgba(255, 255, 255, 0.2);
        /* biar input terlihat */
        border: 1px solid rgba(255, 255, 255, 1);
    }

    .form-control:focus {
        background-color: rgba(255, 255, 255, 1);
        border-color: #0d6efd;
        box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
    }
</style>

<body style="background-image: url('/Assets/img/bg.jpg');
             background-size: cover;
             background-repeat: no-repeat;
             background-position: center;">

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg bg-transparent text-dark w-100">
                <div class="card-header"
                    style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff;">
                    <div class="text-center my-4">
                        <img src="/Assets/img/logo.png" alt="Logo Damkar"
                            style="width: 100px; height: 100px; object-fit: contain;">
                        <h3 class="mt-3" style="font-weight: bold; color: #000000ff;">
                            DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN
                        </h3>
                    </div>

                </div>
                <div class="card-body"
                    style="background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); color: #fff;">
                    <form role="form" method="post" action="<?= base_url('admin/autentikasi'); ?>" id="loginForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="username" name="username" />
                            <label for="inputUsename">Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" placeholder="Password" name="password" />
                            <label for="inputPassword">Password</label>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                            <a href="<?= base_url('admin/daftar'); ?>" class="btn btn-warning">Daftar</a>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Loading',
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            setTimeout(() => {
                this.submit();
            }, 0);
        });
    </script>
    <script>
        let hasil = '<?= session()->getFlashdata('hasil') ?>';
        if (hasil) {
            let title, text, icon, url;
            if (hasil == 'Berhasil') {
                title = 'Login successful!';
                text = 'Selamat Datang ';
                icon = 'success';
            } else {
                title = 'Login failed!';
                text = 'Silahkan cek kembali Username dan password anda';
                icon = 'error';
            }
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'ok'
            }).then(() => {
                if (hasil == 'Berhasil') {
                    window.location.href = '/admin/main';
                }
            });
        }
    </script>
</body>

</html>