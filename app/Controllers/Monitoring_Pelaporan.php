<?php

namespace App\Controllers;

use App\Models\M_Folder_Mon;
use App\Models\M_Monitoring;
use App\Controllers\BaseController;

class Monitoring_Pelaporan extends BaseController
{
    protected $folderModel;
    protected $fileModel;

    public function __construct()
    {
        $this->folderModel = new M_Folder_Mon();
        $this->fileModel = new M_Monitoring();
    }

public function Monitoring($id = null)
{
    // Ambil folder saat ini
    $currentFolder = $id ? $this->folderModel->find($id) : null;

    // Buat breadcrumb
    $breadcrumb = $this->generateBreadcrumb($id);

    // Ambil folder di dalam folder ini (urutkan dari terbaru)
    $folders = $this->folderModel
        ->where('id_parent', $id)
        ->orderBy('created', 'DESC')
        ->findAll();

    // Ambil file di dalam folder ini atau di root (jika belum buka folder)
    if ($id) {
        // 📁 Jika sedang dalam folder tertentu → urutkan dari yang terbaru
        $files = $this->fileModel
            ->where('id_folder_mon', $id)
            ->orderBy('created', 'DESC')
            ->findAll();
    } else {
        // 🏠 Jika belum masuk folder mana pun (root)
        $files = $this->fileModel
            ->groupStart()
            ->where('id_folder_mon', null)
            ->orWhere('id_folder_mon', '')
            ->groupEnd()
            ->orderBy('created', 'DESC')
            ->findAll();
    }

    $data = [
        'breadcrumb' => $breadcrumb,
        'current_folder' => $currentFolder ? $currentFolder['nama_folder_mon'] : 'Monitoring Pelaporan',
        'folders' => $folders,
        'files' => $files,
        'id_parent' => $id,
        'asal' => 'monitoring'
    ];

    echo view('Backend/Template/header');
    echo view('Backend/Template/sidebar', $data);
    echo view('Backend/Main/Monitoring_Pelaporan/monitor', $data);
    echo view('Backend/Template/fuuter');
}


    // Tambah folder
    public function addFolder()
    {
        $modelFolder = new M_Folder_Mon;
        $hasil = $modelFolder->autoNumber()->getRowArray();
        if (!$hasil) {
            $id = "FLMON00001";
        } else {
            $kode = $hasil['id_folder_mon'];
            $noUrut = (int)substr($kode, -3);
            $noUrut++;
            $id = "FLMON" . sprintf("%05s", $noUrut);
        }

        $name = $this->request->getPost('nama');
        $pemilik = $this->request->getPost('pemilik');
        $parentId = $this->request->getPost('id_parent') ?: null;

        $dataUpdate = [
            'id_folder_mon'   => $id,
            'nama_folder_mon' => $name,
            'id_parent' => $parentId, // ubah dari parent_id
            'pemilik' => $pemilik,
            'created' => date('Y-m-d H:i:s')
        ];
        $modelFolder->saveDataFolderMon($dataUpdate);

        return redirect()->to('/admin/monitoring/' . ($parentId ?? ''));
    }



    // Tambah file
public function addFile()
{
    $modelFolder = new M_Monitoring();
    $hasil = $modelFolder->autoNumber()->getRowArray();

    if (!$hasil) {
        $noUrut = 1;
    } else {
        $kode = $hasil['id_monitoring'];
        $noUrut = (int)substr($kode, -5) + 1;
    }

    // Ambil semua file
    $files = $this->request->getFiles();

    if (empty($files['file'])) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Tidak ada file yang diupload!'
        ]);
    }

    // Inisialisasi library Google Drive
    $drive = new \App\Libraries\GoogleDrive();

    $uploadResults = [];

    // Loop setiap file yang diupload
    foreach ($files['file'] as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
            $id = "FILMN" . sprintf("%05s", $noUrut++);

            $fileName = $file->getClientName();
            $filePath = $file->getTempName();

            try {
                // Upload ke Google Drive
                $fileUrl = $drive->uploadFile($filePath, $fileName);

                // Simpan ke database
                $data = [
                    'id_monitoring' => $id,
                    'nama_file'      => $fileName,
                    'id_folder_mon'  => $this->request->getPost('folder_id'),
                    'pemilik'        => $this->request->getPost('pemilik'),
                    'link'           => $fileUrl,
                    'created'        => date('Y-m-d H:i:s')
                ];
                $modelFolder->saveDataMonitoring($data);

                $uploadResults[] = [
                    'file' => $fileName,
                    'status' => 'success',
                    'link' => $fileUrl
                ];
            } catch (\Throwable $e) {
                $uploadResults[] = [
                    'file' => $fileName,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        } else {
            $uploadResults[] = [
                'file' => $file->getClientName(),
                'status' => 'error',
                'message' => 'File tidak valid'
            ];
        }
    }

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Upload selesai',
        'results' => $uploadResults
    ]);
}


    // Fungsi breadcrumb rekursif
    private function generateBreadcrumb($folderId)
    {
        $breadcrumb = [];
        while ($folderId) {
            $folder = $this->folderModel->find($folderId);
            if ($folder) {
                $breadcrumb[] = $folder;
                $folderId = $folder['id_parent'];
            } else break;
        }
        return array_reverse($breadcrumb);
    }
        public function Hapus_file($idHash)
    {
        $model = new \App\Models\M_Monitoring();
        $drive = new \App\Libraries\GoogleDrive();

        // Ambil data hukum berdasarkan hash
        $data = $model->where('SHA1(id_monitoring)', $idHash)->first();

        if ($data) {
            // Ambil file_id dari URL Google Drive
            $fileUrl = $data['link']; // contoh: https://drive.google.com/file/d/1AbCdEfGhIjK/view
            preg_match('/\/d\/(.*?)\//', $fileUrl, $matches);
            $fileId = $matches[1] ?? null;

            // Hapus di Google Drive
            if ($fileId) {
                $drive->deleteFile($fileId);
            }

            // Hapus dari database
            $model->where('id_monitoring', $data['id_monitoring'])->delete();

            session()->setFlashdata('hasil', 'kegiatan_hapus');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan!');
        }

        return redirect()->back();
    }
        public function getProgress()
{
    $progressFile = WRITEPATH . 'logs/drive_progress.json';
    if (file_exists($progressFile)) {
        $data = json_decode(file_get_contents($progressFile), true);
        return $this->response->setJSON($data);
    } else {
        return $this->response->setJSON(['progress' => 0]);
    }
}
public function saveDriveFile()
{
    $data = $this->request->getJSON(true);

    $model = new \App\Models\M_Monitoring();
    $model->insert([
        'nama_file' => $data['fileName'],
        'link' => $data['link'],
        'id_folder_mon' => 'FLRPR00002',
        'pemilik' => session()->get('ses_user'),
        'created' => date('Y-m-d H:i:s')
    ]);

    return $this->response->setJSON(['status' => 'success']);
}
public function search()
{
    $keyword = $this->request->getPost('keyword');

    $fileModel = new \App\Models\M_Monitoring();
    $folderModel = new \App\Models\M_Folder_Mon();

    // Cari di kedua tabel
    $files = $fileModel->like('nama_file', $keyword)
                       ->orLike('pemilik', $keyword)
                       ->findAll();

    $folders = $folderModel->like('nama_folder_mon', $keyword)
                           ->orLike('pemilik', $keyword)
                           ->findAll();

    // Kirim data JSON ke frontend
    return $this->response->setJSON([
        'files' => $files,
        'folders' => $folders
    ]);
}
public function downloadSelected()
{
    $ids = $this->request->getPost('selected_files');
    if (!$ids) {
        return $this->response->setBody('Tidak ada file dipilih.');
    }

    helper('filesystem');

    // Pastikan folder temp ada
    $tempPath = WRITEPATH . 'temp/';
    if (!is_dir($tempPath)) {
        mkdir($tempPath, 0777, true);
    }

    $model = new \App\Models\M_Monitoring();
    $zip = new \ZipArchive();
    $zipName = 'download_' . time() . '.zip';
    $zipPath = $tempPath . $zipName;

    if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
        return $this->response->setBody('Gagal membuat ZIP');
    }

    foreach ($ids as $id) {
        $file = $model->find($id);
        if ($file && !empty($file['link'])) {
            // 🔹 Ambil fileId dari URL Google Drive
            if (preg_match('/[-\w]{25,}/', $file['link'], $matches)) {
                $fileId = $matches[0];
                $downloadUrl = "https://drive.google.com/uc?export=download&id={$fileId}";

                // 🔹 Ambil konten binary
                $fileContent = @file_get_contents($downloadUrl);

                if ($fileContent !== false) {
                    $zip->addFromString($file['nama_file'], $fileContent);
                }
            }
        }
    }

    $zip->close();

    if (!file_exists($zipPath)) {
        return $this->response->setBody('ZIP gagal dibuat');
    }

    // 🔹 Siapkan response untuk download
    $response = $this->response->download($zipPath, null)->setFileName($zipName);

    register_shutdown_function(function () use ($zipPath) {
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
    });

    return $response;
}

    public function hapus_folder($hash_id)
{
    $folderModel = new \App\Models\M_Folder_Mon();
    $fileModel   = new \App\Models\M_Monitoring();

    // 🔹 Cari ID asli dari hash
    $folder = $folderModel->where('SHA1(id_folder_mon)', $hash_id)->first();

    if (!$folder) {
        return redirect()->back()->with('error', 'Folder tidak ditemukan.');
    }

    $id = $folder['id_folder_mon'];

    // 🔹 Cek apakah masih ada subfolder di dalamnya
    $subfolder = $folderModel->where('id_parent', $id)->countAllResults();

    // 🔹 Cek apakah masih ada file di dalam folder ini
    $files = $fileModel->where('id_folder_mon', $id)->countAllResults();

    if ($subfolder > 0 || $files > 0) {
        return redirect()->back()->with(
            'error',
            'Folder tidak dapat dihapus karena masih berisi subfolder atau file.'
        );
    }

    // 🔹 Hapus folder dari database
    $folderModel->where('id_folder_mon', $id)->delete();

    return redirect()->back()->with('success', 'Folder berhasil dihapus.');
}
public function deleteSelectedFiles()
{
    $ids = $this->request->getPost('ids'); // array id_monitoring asli
    if (!$ids || !is_array($ids)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak ada file yang dipilih.']);
    }

    $model = new \App\Models\M_Monitoring();
    $drive = new \App\Libraries\GoogleDrive();
    $deletedCount = 0;

    foreach ($ids as $id) {
        $data = $model->where('id_monitoring', $id)->first();
        if ($data) {
            // 🔹 Ambil file_id dari URL Google Drive
            if (preg_match('/[-\w]{25,}/', $data['link'], $matches)) {
                $fileId = $matches[0];
                try {
                    $drive->deleteFile($fileId);
                } catch (\Throwable $e) {
                    log_message('error', 'Gagal hapus di Google Drive: ' . $e->getMessage());
                }
            }

            // 🔹 Hapus dari database
            $model->delete($data['id_monitoring']);
            $deletedCount++;
        }
    }

    if ($deletedCount > 0) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => "Berhasil menghapus {$deletedCount} file."
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Tidak ada file yang berhasil dihapus.'
        ]);
    }
}
public function addLink()
{
    $nama = $this->request->getPost('nama_file');
    $link = $this->request->getPost('link');
    $folderId = $this->request->getPost('folder_id');
    $pemilik = $this->request->getPost('pemilik');

    if (empty($nama) || empty($link)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Nama dan link wajib diisi!'
        ]);
    }

    $model = new \App\Models\M_Monitoring();
    $hasil = $model->autoNumber()->getRowArray();

    if (!$hasil) {
        $noUrut = 1;
    } else {
        $kode = $hasil['id_monitoring'];
        $noUrut = (int)substr($kode, -5) + 1;
    }

    $id = "FILMN" . sprintf("%05s", $noUrut);

    $data = [
        'id_monitoring' => $id,
        'nama_file'      => $nama,
        'id_folder_mon'  => $folderId,
        'pemilik'        => $pemilik,
        'link'           => $link,
        'created'        => date('Y-m-d H:i:s')
    ];

    $model->saveDataMonitoring($data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Link berhasil disimpan.'
    ]);
}
public function editItem()
{
    $tipe = $this->request->getPost('tipe'); // folder atau file
    $id   = $this->request->getPost('id');
    $nama = $this->request->getPost('nama');

    if (empty($id) || empty($nama)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap.']);
    }

    $now = date('Y-m-d H:i:s');

    if ($tipe === 'folder') {
        $model = new \App\Models\M_Folder_Mon();
        $update = $model->where('id_folder_mon', $id)->set([
            'nama_folder_mon' => $nama,
            'created' => $now
        ])->update();
    } else {
        $model = new \App\Models\M_Monitoring();
        $update = $model->where('id_monitoring', $id)->set([
            'nama_file' => $nama,
            'created' => $now
        ])->update();
    }

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
