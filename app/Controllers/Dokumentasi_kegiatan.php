<?php

namespace App\Controllers;

//bawah model database
use App\Libraries\GoogleDrive;
use App\Models\M_Dokumentasi;
use App\Models\M_DokumentasiFile;



class Dokumentasi_kegiatan extends BaseController
{
    public function Dokumentasi()
    {
        $modeldokumentasi = new M_Dokumentasi;
        $modeldokumentasiFile = new M_DokumentasiFile();
        $dataUser = $modeldokumentasi->getDataDokumentasi()->getResultArray();
        $dataUser1 = $modeldokumentasiFile->getDataDokumentasiFile()->getResultArray();
        $kirim['data_user'] = $dataUser;
        $kirim['data_user1'] = $dataUser1;

        $pages = "dokumentasi";

        $kirim['asal'] = $pages;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $kirim);
        echo view('Backend/Main/Dokumentasi/dokumentasi_pep', $kirim);
        echo view('Backend/Template/fuuter');

    }


    public function detail($id)
    {
        $model = new M_Dokumentasi();
        $fileModel = new M_DokumentasiFile();

        $data['kegiatan'] = $model->find($id);
        $data['files'] = $fileModel->where('id_kegiatan', $id)->findAll();

        $pages = "dokumentasi";

        $data['asal'] = $pages;
        echo view('Backend/Template/header');
        echo view('Backend/Template/sidebar', $data);
        echo view('Backend/Main/Dokumentasi/detail', $data);
        echo view('Backend/Template/fuuter');
    }

public function simpan()
{
    $model = new M_Dokumentasi();
    $fileModel = new M_DokumentasiFile();
    $drive = new GoogleDrive();

    $nama = $this->request->getPost('nama_kegiatan');
    $tanggal = $this->request->getPost('tanggal');
    $keterangan = $this->request->getPost('keterangan');
    $files = $this->request->getFiles()['thumbnail'] ?? [];

    // 🔹 Cek apakah kegiatan sudah ada
    $kegiatan = $model->where('nama_kegiatan', $nama)->first();

    if (!$kegiatan) {
        // 🔹 Buat ID baru untuk kegiatan
        $hasil = $model->select('id_kegiatan')->orderBy('id_kegiatan', 'DESC')->first();
        $noUrut = (!$hasil) ? 1 : (int) substr($hasil['id_kegiatan'], -5) + 1;
        $idKegiatan = "DKMFD" . sprintf("%05s", $noUrut);

        // Simpan kegiatan baru (ekstensi dan thumbnail diupdate nanti)
        $model->insert([
            'id_kegiatan' => $idKegiatan,
            'nama_kegiatan' => $nama,
            'keterangan' => $keterangan,
            'tanggal_kegiatan' => $tanggal,
            'created' => date('Y-m-d H:i:s')
        ]);
    } else {
        $idKegiatan = $kegiatan['id_kegiatan'];
    }

    // 🔹 Upload setiap file
    $thumbnailSet = false;
    $ekstensiSet = false;

    // 🔹 Ambil ID file terakhir hanya sekali
    $hasil1 = $fileModel->select('id_file')->orderBy('id_file', 'DESC')->first();
    $noUrutFile = (!$hasil1) ? 1 : (int) substr($hasil1['id_file'], -5) + 1;

    $allowed = ['jpg', 'jpeg', 'png', 'jfif', 'mp4', 'mkv', 'pdf'];

    foreach ($files as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, $allowed)) continue;

            $originalName = $file->getClientName();
            $filePath = $file->getTempName();

            // 🔹 Upload ke Google Drive
            $url = $drive->uploadFile($filePath, $originalName);
            if (!$url) continue;

            // 🔹 Buat ID unik untuk setiap file
            $idFile = "DKMFL" . sprintf("%05s", $noUrutFile++);

            // 🔹 Simpan ke tabel file
            $fileModel->insert([
                'id_file' => $idFile,
                'id_kegiatan' => $idKegiatan,
                'file_url' => $url,
                'ekstensi' => $ext,
                'created' => date('Y-m-d H:i:s')
            ]);

            // 🔹 Set ekstensi pertama untuk tabel dokumentasi
            if (!$ekstensiSet) {
                $model->update($idKegiatan, ['ekstensi' => $ext]);
                $ekstensiSet = true;
            }

            // 🔹 Set thumbnail pertama yang berupa gambar
            if (!$thumbnailSet && in_array($ext, ['jpg', 'jpeg', 'png', 'jfif'])) {
                $model->update($idKegiatan, ['thumbnail' => $url]);
                $thumbnailSet = true;
            }
        }
    }

    return redirect()->to('/admin/dokumentasi')->with('hasil', 'upload_sukses');
}



    public function edit()
    {
        $id = $this->request->getPost('id_kegiatan');
        $nama = $this->request->getPost('nama_kegiatan');
        $ket = $this->request->getPost('keterangan');

        if (empty($id) || empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap.']);
        }

        $model = new \App\Models\M_Dokumentasi();
        $update = $model->where('id_kegiatan', $id)->set([
            'nama_kegiatan' => $nama,
            'keterangan' => $ket,
            'created' => date('Y-m-d H:i:s')
        ])->update();

        if ($update) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Dokumentasi berhasil diperbarui.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui data.'
            ]);
        }
    }

    public function Hapus_dokumentasi($idHash)
    {
        $model = new \App\Models\M_Dokumentasi();
        $drive = new \App\Libraries\GoogleDrive();

        // Ambil data hukum berdasarkan hash
        $data = $model->where('SHA1(id_kegiatan)', $idHash)->first();

        if ($data) {
            // Ambil file_id dari URL Google Drive
            $fileUrl = $data['thumbnail']; // contoh: https://drive.google.com/file/d/1AbCdEfGhIjK/view
            preg_match('/\/d\/(.*?)\//', $fileUrl, $matches);
            $fileId = $matches[1] ?? null;

            // Hapus di Google Drive
            if ($fileId) {
                $drive->deleteFile($fileId);
            }

            // Hapus dari database
            $model->where('id_kegiatan', $data['id_kegiatan'])->delete();

            session()->setFlashdata('hasil', 'kegiatan_hapus');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->back();
    }

}