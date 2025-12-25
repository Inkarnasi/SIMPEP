<div class="col-md-10 " style="background-color: #F5F5DC;">
  <div class="row">
    <div class="d-flex flex-column">
        <div class="p-2 " >
          <i class="bi-gear text-decoration-none" style="color: #808080;">/Setting</i>
        </div>
        <div class="p-2 flex-grow-1 ">
          <div class="d-flex justify-content-between mb-3">
            <h2 class="" style="color: #808080;" >Daftar Admin</h2>
            <div>
                <a href="/admin/input_admin" class="btn btn-primary" style="color: #FFFFFF; background-color: #20B2AA;--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Tambah</a>
                <a class="btn btn-info" style="color: #FFFFFF; background-color: #20B2AA; --bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Cetak Daftar Anggota</a>
            </div>
          </div>
          <hr>
          
            <table class="table table-striped">
              <thead>
                <tr>
				    <th data-sortable="true">#</th>
				    <th data-sortable="true">Nama Admin</th>
				    <th data-sortable="true">Username Admin</th>

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
                        <td data-sortable="true"><?= $data['nama_admin'];?></td>
                        <td data-sortable="true"><?= $data['username_admin'];?></td>
                       
                        <td data-sortable="true">
                            <a href="<?= base_url('/admin/edit_data_admin/'.sha1($data['id_admin']));?>"><button type="button" class="btn btn-sm btn-success">Edit</button></a>
                            <a href="#" onclick="doDelete('<?= sha1($data['id_admin']);?>')"><button type="button" class="btn btn-sm btn-danger">Hapus</button></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
          <div class="pager d-flex justify-content-between">
            <span id="page-num" class=" text-light">Hal : 1 </span>
              <div class="border p-2 d-flex">
                <button class="btn btn-light btn-sm me-2">Previous</button>
                <button class="btn btn-light btn-sm ms-2">Next</button>
              </div>
          </div>
        </div>
          



    </div><!--  dflex -->
  </div><!-- row  -->
</div><!-- main -->


      

    </div><!-- row sidebar -->
</div> <!-- containerw sidebar -->




