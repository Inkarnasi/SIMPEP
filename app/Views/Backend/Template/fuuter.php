


</body>
<script src="/Assets/js/bootstrap.bundle.min.js"></script>
<script src="/Assets/js/up_down_listgroup.js"></script>

<script src="/Assets/js/sweetalert2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</hmtl>

<script>
    //script opsi form jenis anggota
  $(document).ready(function(){
    $('#jenisAnggota').change(function(){
      if($(this).val() == 'P') {
        $('#tipePinjamanLabel').show();
        $('#totalPinjamanLabel, #totalPinjaman').show();
        // atas pinjaman, bawah bukti
        $('#fotoBukti').hide();
        $('#atasBukti, #bawahBukti').hide();
      } else if ($(this).val() == 'SP'){
        $('#tipePinjamanLabel').hide();
        $('#totalPinjamanLabel, #totalPinjaman').hide();
        // sama kaya atas
        $('#fotoBukti').show();
        $('#atasBukti, #bawahBukti').show();
      } else {
        $('#tipePinjamanLabel').hide();
        $('#totalPinjamanLabel, #totalPinjaman').hide();

        $('#fotoBukti').hide();
        $('#atasBukti, #bawahBukti').hide();
      }
    });
  });
  </script>
  <script>
    // untuk limit angka
    document.getElementById('totalPinjaman').addEventListener('input', function (e) {
      var max = 3000000; // maks pinjaman
      var value = parseInt(e.target.value);
  
      if (value > max) {
        e.target.value = max;
        alert('Total pinjaman tidak boleh lebih dari Rp3.000.000');
        }
      });

  </script>
  
  <script>
    //script form anggota
  let hasil = '<?= session()->getFlashdata('hasil') ?>';
            //form
            if (hasil == 'Berhasil') {
              Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Anggota Telah Tersimpan',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                } else if (hasil == 'gak_jelas') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Data Anggota Tidak Valid',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    }); //batas form
                }  else if (hasil == 'Masuk') {
                  // tambah admin
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Admin Telah Tersimpan',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                }else if (hasil == 'gagal_admin') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Data Admin Tidak Valid',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                } else if (hasil == 'hapus_admin') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Admin Telah Terhapus',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    })// batas tambah admin
                }else if (hasil == 'status_s') {
                  Swal.fire({
                    //ini update status
                        position: 'top-end',
                        icon: 'success',
                        title: 'Status Data Anggota Telah Berubah',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                }else if (hasil == 'update_done') {
                  Swal.fire({
                    //ini update data simpanan dan pinjaman
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data telah ter-update',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                }else if (hasil == 'hukum_simpan') {
                  Swal.fire({
                    //ini bayar simpanan
                        position: 'top-end',
                        icon: 'success',
                        title: 'File Berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                }else if (hasil == 'hukum_hapus') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'File Hukum Telah Terhapus',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    })
                }else if (hasil == 'dokumentasi_simpan') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Foto Berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    });
                }else if (hasil == 'dokumentasi_hapus') {
                  Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Foto Dokumentasi Telah Terhapus',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'my-swal'
                        }
                    })
                }
                
                
                
  </script>







<script >
  // alert logout
  document.getElementById('logoutButton').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success",
            cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
    }).fire({
      title: "Konfirmasi",
      text: "Apakah Anda yakin ingin keluar dari website ini?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, saya yakin",
      cancelButtonText: "Tidak, batalkan",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/logout';
        }
    });
});

</script>




<script type="text/javascript">
    // untuk hapus akun admin
    function doDelete(idDelete){
        Swal.fire({
            title: 'Hapus Data Admin?',
            text: "Data ini akan terhapus secara permanen!!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url();?>/admin/hapus_data_admin/' + idDelete;
            }
        })
    }
</script>

<script type="text/javascript">
    // untuk ganti status anggota simpanan
    function doUbahS(idUbah){
        Swal.fire({
            title: 'Ubah Status Anggota?',
            text: "Data ini akan terubah statusnya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url();?>/admin/ubah_status_s/' + idUbah;
            }
        })
    }
</script>

<script type="text/javascript">
    // untuk ganti status anggota pinjaman
    function doUbahP(idUbah){
        Swal.fire({
            title: 'Ubah Status Anggota?',
            text: "Data ini akan terubah statusnya",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ubah!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url();?>/admin/ubah_status_p/' + idUbah;
            }
        })
    }
</script>

