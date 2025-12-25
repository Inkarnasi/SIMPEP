<?php
namespace App\Libraries;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
require_once APPPATH . '../vendor/autoload.php';


class GoogleDrive {
    private $client;
    private $service;
    private $defaultFolderId = '1SXN35B2K4WDujaJdDwYA0_94wuvpoRPR'; // ID folder PEP
    private $tokenPath;

    public function __construct() {
        $this->client = new Client();
        $this->client->setAuthConfig(WRITEPATH . '../credentials/credentials.json');
        $this->client->addScope(Drive::DRIVE);
        $this->client->setAccessType('offline'); // penting: agar dapat refresh token
        $this->client->setPrompt('select_account consent');
        // Path ke token.json
        $this->tokenPath = WRITEPATH . '../credentials/token.json';

        // 🔹 Jika token.json sudah ada, gunakan token itu
        if (file_exists($this->tokenPath)) {
            $accessToken = json_decode(file_get_contents($this->tokenPath), true);
            $this->client->setAccessToken($accessToken);
        }

        // 🔹 Jika token expired, refresh otomatis
        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $newToken = $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                file_put_contents($this->tokenPath, json_encode($this->client->getAccessToken()));
            } else {
                throw new \Exception('Token Google Drive expired dan tidak memiliki refresh token. Jalankan ulang getToken.php.');
            }
        }

        // 🔹 Inisialisasi service Google Drive
        $this->service = new Drive($this->client);

    }

    // ✅ Upload file ke Google Drive
 public function uploadFile($filePath, $fileName, $folderId = null)
    {
        $folderId = $folderId ?? $this->defaultFolderId;

        // Metadata file
        $fileMetadata = new DriveFile([
            'name' => $fileName,
            'parents' => [$folderId],
        ]);

        // Open stream file untuk upload besar
        $chunkSizeBytes = 5 * 1024 * 1024; // 5MB per chunk
        $client = $this->service->getClient();
        $client->setDefer(true); // agar upload bisa dikontrol manual

        // Buat request upload
        $request = $this->service->files->create($fileMetadata, [
            'fields' => 'id',
        ]);

        // Siapkan media upload (resumable)
        $media = new \Google\Http\MediaFileUpload(
            $client,
            $request,
            mime_content_type($filePath),
            null,
            true,                // resumable upload aktif
            $chunkSizeBytes
        );

        $media->setFileSize(filesize($filePath));

        // Buka file dan kirim per-chunk
        $handle = fopen($filePath, "rb");
        while (!feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $status = $media->nextChunk($chunk);
        }
        fclose($handle);

        // Aktifkan kembali request langsung
        $client->setDefer(false);

        // Ambil hasil upload (ID file)
        if ($status && isset($status->id)) {
            // Bikin file bisa dibaca publik (opsional)
            $this->service->permissions->create($status->id, new \Google\Service\Drive\Permission([
                'type' => 'anyone',
                'role' => 'reader'
            ]));

            // Kembalikan URL Drive
            return "https://drive.google.com/file/d/" . $status->id . "/view";
        }

        throw new \Exception("Upload ke Google Drive gagal.");
    }

        // 🔥 Hapus file dari Google Drive berdasarkan file ID
    public function deleteFile($fileId)
    {
        try {
            $this->service->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
            log_message('error', 'Gagal hapus file Drive: ' . $e->getMessage());
            return false;
        }
    }
public function getDriveStorageInfo()
{
    try {
        $about = $this->service->about->get(['fields' => 'storageQuota']);
        $quota = $about->getStorageQuota();

        $limit = isset($quota['limit']) ? (float)$quota['limit'] : 0; // total storage (bytes)
        $usage = isset($quota['usage']) ? (float)$quota['usage'] : 0; // total usage (bytes)

        $remaining = $limit - $usage;

        // Convert ke GB biar mudah dibaca
        $toGB = function($bytes) {
            return round($bytes / (1024 * 1024 * 1024), 2);
        };

        return [
            'total_gb' => $toGB($limit),
            'used_gb' => $toGB($usage),
            'remaining_gb' => $toGB($remaining)
        ];

    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
public function getStorageByFileType()
{
    $results = [];
    $totalUsed = 0;

    // Ambil daftar file di Drive
    $files = $this->service->files->listFiles([
        'fields' => 'files(id, name, mimeType, size)'
    ]);

    if (count($files->getFiles()) == 0) {
        return [];
    }

    foreach ($files->getFiles() as $file) {
        $mime = $file->mimeType ?? 'unknown';
        $size = isset($file->size) ? (int)$file->size : 0;

        // Kelompokkan berdasarkan tipe file utama
        if (str_contains($mime, 'pdf')) $type = 'PDF';
        elseif (str_contains($mime, 'image')) $type = 'Gambar';
        elseif (str_contains($mime, 'msword') || str_contains($mime, 'officedocument')) $type = 'Dokumen';
        elseif (str_contains($mime, 'video')) $type = 'Video';
        else $type = 'Lainnya';

        if (!isset($results[$type])) {
            $results[$type] = 0;
        }

        $results[$type] += $size;
        $totalUsed += $size;
    }

    // Konversi ke GB dan hitung persentase
    $data = [];
    foreach ($results as $type => $size) {
        $gb = round($size / (1024 ** 3), 2);
        $percent = $totalUsed > 0 ? round(($size / $totalUsed) * 100, 2) : 0;
        $data[] = [
            'type' => $type,
            'size_gb' => $gb,
            'percent' => $percent
        ];
    }

    return $data;
}

}
