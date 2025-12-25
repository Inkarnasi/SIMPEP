<?php

namespace App\Controllers;

class ImageController extends BaseController
{
public function imageProxy($fileId)
{
    $url = "https://drive.google.com/uc?export=view&id=" . $fileId;

    // ambil file dari drive
    $context = stream_context_create([
        "http" => ["ignore_errors" => true]
    ]);
    $imageData = @file_get_contents($url, false, $context);

    if ($imageData === false) {
        header("HTTP/1.1 404 Not Found");
        echo "Gambar tidak ditemukan atau tidak bisa diakses.";
        exit;
    }

    // deteksi MIME otomatis
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_buffer($finfo, $imageData);
    finfo_close($finfo);

    header("Content-Type: " . $mime);
    echo $imageData;
    exit;
}

}
