<?php

namespace App\Controllers;

use App\Libraries\GoogleDrive;
class Penyimpanan extends BaseController
{
public function Penyimpanan()
{
    $drive = new \App\Libraries\GoogleDrive();

    $storage = $drive->getDriveStorageInfo();
    $fileTypes = $drive->getStorageByFileType();
        $pages = "penyimpanan";

        $kirim ['asal'] = $pages;
        echo view ('Backend/Template/header');
        echo view ('Backend/Template/sidebar', $kirim);
        echo view ('Backend/Main/Penyimpanan/penyimpanan',[
        'storage' => $storage,
        'fileTypes' => $fileTypes
    ]);
        echo view ('Backend/Template/fuuter');
}

}