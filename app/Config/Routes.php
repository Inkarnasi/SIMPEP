<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/test','Admin::Test');
$routes->get('/admin/main','Beranda::Beranda');

#Routes Dasar Hukum
$routes->get('/admin/dasarhukum/(:alphanum)','Dasar_Hukum::Dasar_Hukum/$1');
$routes->get('/admin/dasarhukum','Dasar_Hukum::Dasar_Hukum');
$routes->post('/admin/dasarhukum/addHukum','Dasar_Hukum::addHukum');
$routes->get('/admin/dasarhukum/index', 'Mekanisme\Dasar_Hukum::index');
$routes->get('/admin/dasarhukum/hapus/(:alphanum)','Dasar_Hukum::Hapus_file/$1');
$routes->get('/admin/dasarhukum/progress', 'Dasar_Hukum::getProgress');
$routes->post('/admin/dasarhukum/saveDriveFile','Dasar_Hukum::saveDriveFile');
$routes->post('admin/dasarhukum/search', 'Dasar_Hukum::search');
$routes->get('/admin/dasarhukum/hapus_folder/(:alphanum)','Dasar_Hukum::Hapus_folder/$1');
$routes->post('/admin/dasarhukum/deleteSelectedHukum', 'Dasar_Hukum::deleteSelectedHukum');
$routes->get('download-temp/(:any)', function($file) {
    $path = WRITEPATH . 'temp/' . $file;

    if (file_exists($path)) {
        return service('response')->download($path, null);
    }

    throw new \CodeIgniter\Exceptions\PageNotFoundException("File tidak ditemukan: {$file}");
});
$routes->post('admin/dasarhukum/editItem','Dasar_Hukum::editItem');


#Routes Mekanisme
$routes->get('/admin/mekanisme/(:alphanum)','Mekanisme::Mekanisme/$1');
$routes->get('/admin/mekanisme','Mekanisme::Mekanisme');
$routes->post('/admin/mekanisme/addFolder','Mekanisme::addFolder');
$routes->post('/admin/mekanisme/addFile','Mekanisme::addFile');
$routes->get('/admin/mekanisme/index', 'Mekanisme\Mekanisme::index');
$routes->get('/admin/mekanisme/hapus/(:alphanum)','Mekanisme::Hapus_file/$1');
$routes->get('/admin/mekanisme/progress', 'Mekanisme::getProgress');
$routes->post('/admin/mekanisme/saveDriveFile','Mekanisme::saveDriveFile');
$routes->post('admin/mekanisme/search', 'Mekanisme::search');
$routes->get('/admin/mekanisme/hapus_folder/(:alphanum)','Mekanisme::Hapus_folder/$1');
$routes->post('/admin/mekanisme/deleteSelectedFiles', 'Mekanisme::deleteSelectedFiles');
$routes->post('/admin/mekanisme/downloadSelected', 'Mekanisme::downloadSelected');
$routes->get('download-temp/(:any)', function($file) {
    $path = WRITEPATH . 'temp/' . $file;

    if (file_exists($path)) {
        return service('response')->download($path, null);
    }

    throw new \CodeIgniter\Exceptions\PageNotFoundException("File tidak ditemukan: {$file}");
});
$routes->post('/admin/mekanisme/addLink','Mekanisme::addLink');
$routes->post('admin/mekanisme/editItem','Mekanisme::editItem');
$routes->post('/admin/mekanisme/addMultipleFolders', 'Mekanisme::addMultipleFolders');



#Routes Dokumentasi Kegiatan
$routes->get('/admin/dokumentasi','Dokumentasi_kegiatan::Dokumentasi');
$routes->post('admin/dokumentasi/simpan','Dokumentasi_kegiatan::Simpan');
$routes->get('/admin/dokumentasi/hapus/(:alphanum)','Dokumentasi_kegiatan::Hapus_dokumentasi/$1');
$routes->get('image/(:segment)', 'ImageController::imageProxy/$1');
$routes->post('admin/dokumentasi/editItem','Dokumentasi_Kegiatan::edit');
$routes->get('/admin/dokumentasi/detail/(:segment)', 'Dokumentasi_Kegiatan::detail/$1');





#Routes Login-Daftar
$routes->get('/admin/login','Admin::Login');
$routes->get('/admin/logout','Admin::Logout');
$routes->get('/admin/daftar','Admin::daftar');
$routes->post('/admin/daftar/simpan','Admin::simpan_daftar');
$routes->post('/admin/autentikasi', 'Admin::autentikasi');

#Routes Penyimpanan
$routes->get('/admin/penyimpanan','Penyimpanan::Penyimpanan');



#Routes Perencanaan
$routes->get('/admin/perencanaan/(:alphanum)','Perencanaan::Perencanaan/$1');
$routes->get('/admin/perencanaan','Perencanaan::Perencanaan');
$routes->post('/admin/perencanaan/addFolder','Perencanaan::addFolder');
$routes->post('/admin/perencanaan/addFile','Perencanaan::addFile');
$routes->get('/admin/perencanaan/index', 'Perencanaan::index');
$routes->get('/admin/perencanaan/hapus/(:alphanum)','Perencanaan::Hapus_file/$1');
$routes->post('/admin/perencanaan/deleteSelectedFiles', 'Perencanaan::deleteSelectedFiles');
$routes->get('/admin/perencanaan/hapus_folder/(:alphanum)','Perencanaan::Hapus_folder/$1');
$routes->get('/admin/perencanaan/progress', 'Perencanaan::getProgress');
$routes->post('/admin/perencanaan/saveDriveFile','Perencanaan::saveDriveFile');
$routes->post('admin/perencanaan/search', 'Perencanaan::search');
$routes->post('/admin/perencanaan/downloadSelected', 'Perencanaan::downloadSelected');
$routes->get('download-temp/(:any)', function($file) {
    $path = WRITEPATH . 'temp/' . $file;

    if (file_exists($path)) {
        return service('response')->download($path, null);
    }

    throw new \CodeIgniter\Exceptions\PageNotFoundException("File tidak ditemukan: {$file}");
});
$routes->post('/admin/perencanaan/addLink','Perencanaan::addLink');
$routes->post('admin/perencanaan/editItem','Perencanaan::editItem');
// === Tambah Banyak Folder Sekaligus ===
$routes->post('/admin/perencanaan/addMultipleFolders', 'Perencanaan::addMultipleFolders');


#Routes Monitoring Pelaporan
$routes->get('/admin/monitoring/(:alphanum)','Monitoring_Pelaporan::Monitoring/$1');
$routes->get('/admin/monitoring','Monitoring_Pelaporan::Monitoring');
$routes->post('/admin/monitoring/addFolder','Monitoring_Pelaporan::addFolder');
$routes->post('/admin/monitoring/addFile','Monitoring_Pelaporan::addFile');
$routes->get('/admin/monitoring/index', 'Monitoring_Pelaporan::index');
$routes->get('/admin/monitoring/hapus/(:alphanum)','Monitoring_Pelaporan::Hapus_file/$1');
$routes->get('/admin/monitoring/progress', 'Monitoring_Pelaporan::getProgress');
$routes->post('/admin/monitoring/saveDriveFile','Monitoring_Pelaporan::saveDriveFile');
$routes->post('admin/monitoring/search', 'Monitoring_Pelaporan::search');
$routes->get('/admin/monitoring/hapus_folder/(:alphanum)','Monitoring_Pelaporan::Hapus_folder/$1');
$routes->post('/admin/monitoring/deleteSelectedFiles', 'Monitoring_Pelaporan::deleteSelectedFiles');
$routes->post('/admin/monitoring/downloadSelected', 'Monitoring_Pelaporan::downloadSelected');
$routes->get('download-temp/(:any)', function($file) {
    $path = WRITEPATH . 'temp/' . $file;

    if (file_exists($path)) {
        return service('response')->download($path, null);
    }

    throw new \CodeIgniter\Exceptions\PageNotFoundException("File tidak ditemukan: {$file}");
});
$routes->post('/admin/monitoring/addLink','Monitoring_Pelaporan::addLink');
$routes->post('admin/monitoring/editItem','Monitoring_Pelaporan::editItem');
$routes->post('/admin/monitoring/addMultipleFolders', 'Monitoring_Pelaporan::addMultipleFolders');
