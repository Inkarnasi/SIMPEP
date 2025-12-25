<?php

namespace App\Controllers;

use ZipArchive;
use App\Models\M_Dasar_Hukum;
use App\Controllers\BaseController;

class Dasar_Hukum extends BaseController
{
    protected $folderModel;
    protected $fileModel;
    public function __construct()
    {
        $this->fileModel = new M_Dasar_Hukum();
    }

    public function Dasar_Hukum()
    {

        $files = $this->fileModel->findAll();
        $data = [
            'current_folder' => 'Dasar Hukum',
            'files' => $files,
            'asal' => 'dasarhukum'
        ];

        // Render tampilan
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Main/Dasar_Hukum/dasarhukum', $data);
        echo view('Backend/Template/fuuter');
    }


public function Hapus_file($idHash)
{
    $model = new \App\Models\M_Dasar_Hukum();
    $data = $model->where('SHA1(id_hukum)', $idHash)->first();

    if ($data) {
        $model->delete($data['id_hukum']);
        session()->setFlashdata('success', 'Berhasil menghapus Hukum.');
    } else {
        session()->setFlashdata('error', 'Data tidak ditemukan.');
    }

    return redirect()->back();
}


public function deleteSelectedHukum()
{
    $ids = $this->request->getPost('ids');

    if (!$ids || !is_array($ids)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Tidak ada file yang dipilih.'
        ]);
    }

    $model = new \App\Models\M_Dasar_Hukum();
    $deleted = $model->whereIn('id_hukum', $ids)->delete();

    if ($deleted) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Berhasil menghapus beberapa data hukum.'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Tidak ada data hukum yang berhasil dihapus.'
        ]);
    }
}


    public function search()
    {
        $keyword = $this->request->getPost('keyword');

        $fileModel = new \App\Models\M_Dasar_Hukum();

        // Cari di kedua tabel
        $files = $fileModel->like('nama_file', $keyword)
            ->orLike('pemilik', $keyword)
            ->findAll();

        // Kirim data JSON ke frontend
        return $this->response->setJSON([
            'files' => $files
        ]);
    }


    public function addHukum()
    {
        $nama = $this->request->getPost(index: 'nama_hukum');
        $pemilik = $this->request->getPost('pemilik');

        if (empty($nama)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Hukum wajib diisi!'
            ]);
        }

        $model = new \App\Models\M_Dasar_Hukum();
        $hasil = $model->autoNumber()->getRowArray();

        if (!$hasil) {
            $noUrut = 1;
        } else {
            $kode = $hasil['id_hukum'];
            $noUrut = (int) substr($kode, -5) + 1;
        }

        $id = "HUKUM" . sprintf("%05s", $noUrut);

        $data = [
            'id_hukum' => $id,
            'nama_hukum' => $nama,
            'pemilik' => $pemilik,
            'created' => date('Y-m-d H:i:s')
        ];

        $model->saveDataHukum($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Hukum berhasil disimpan.'
        ]);
    }
    public function editItem()
    {
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');

        if (empty($id) || empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap.']);
        }

        $now = date('Y-m-d H:i:s');

        $model = new \App\Models\M_Dasar_Hukum();
        $update = $model->where('id_hukum', $id)->set([
            'nama_hukum' => $nama,
            'created' => $now
        ])->update();


        if ($update) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Nama berhasil diperbarui.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui data.'
            ]);
        }
    }

}
