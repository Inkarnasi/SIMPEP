<div class="col-md-10" style="background-color: #F5F5DC; min-height: 100vh;">
  <div class="row">
    <div class="d-flex flex-column" >
      <div class="p-2 " >
        <i class="bi-piggy-bank text-decoration-none" style="color: #808080;">/Simpanan</i>
      </div>
        <div class="p-2 flex-grow-1 ">
          <div class="d-flex justify-content-between mb-3">
            <?php if($status=='aktif') {echo '<h2 class="" style="color: #808080;">Daftar Anggota Simpanan Aktif</h2>';} elseif ($status = "taktif"){echo '<h2 class="" style="color: #808080;">Daftar Anggota Simpanan Tidak Aktif</h2>';}?>
            <div>
              <a href="/admin/form" class="btn btn-primary" style="color: #FFFFFF; background-color: #20B2AA; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Tambah</a>
              <a class="btn btn-info" style="color: #FFFFFF; background-color: #20B2AA; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Cetak Daftar Anggota</a>
            </div>
          </div>
          <hr>
          <form class="d-flex mb-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Cari berdasarkan nama/kode" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>
          <table class="table table-striped">
              <thead>
                <tr>
                  <th data-sortable="true">NO</th>
                  <th data-sortable="true">ID Anggota</th>
                  <th data-sortable="true">Nama Anggota</th>
                  <th data-sortable="true">Tanggal Masuk</th>

                  <th data-sortable="true">Total Simpanan Wajib</th>
                  <th data-sortable="true">Opsi</th>
				        </tr>
              </thead>
                <tbody>
                    <?php
                        $no = 0;
                        foreach($data_user as $data){
                    ?>
                    <tr>
                        <td data-sortable="true"><?= $no=$no+1;?></td>
                        <td data-sortable="true"><?= $data['id_simpanan'];?></td>
                        <td data-sortable="true"><?= $data['nama'];?></td>
                        <td data-sortable="true"><?= $data['created'];?></td>

                        <td data-sortable="true">Rp. <?= $data['total'];?></td>
                        <td>
                          <a href="<?= base_url('admin/anggota_s/detail/'.sha1($data['id_simpanan']));?>" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>

          
  </div><!-- row  -->
</div><!-- main -->


      

    </div><!-- row sidebar -->
</div> <!-- container sidebar -->


