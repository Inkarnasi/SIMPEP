<?php
// --------------------------------------------------------------------
// ✅ AKTIFKAN ERROR REPORTING UNTUK DEBUG
// --------------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);

use CodeIgniter\CodeIgniter;

// --------------------------------------------------------------------
// ✅ CEK VERSI PHP
// --------------------------------------------------------------------
$minPhpVersion = '7.4'; // Sesuaikan jika kamu pakai PHP 8.x, tetap aman
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// --------------------------------------------------------------------
// ✅ DEFINISIKAN PATH KE FRONT CONTROLLER (file ini sendiri)
// --------------------------------------------------------------------
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Pastikan direktori kerja saat ini adalah direktori public
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

// --------------------------------------------------------------------
// ✅ MUAT FILE KONFIGURASI PATHS
// --------------------------------------------------------------------
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

// --------------------------------------------------------------------
// ✅ MUAT BOOTSTRAP CODEIGNITER
// --------------------------------------------------------------------
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// --------------------------------------------------------------------
// ✅ MUAT FILE .ENV (PERBAIKAN BAGIAN INI)
// --------------------------------------------------------------------
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new \CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// --------------------------------------------------------------------
// ✅ DEFINISIKAN ENVIRONMENT
// --------------------------------------------------------------------
if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

// --------------------------------------------------------------------
// ✅ (OPSIONAL) MUAT CONFIG CACHE
// --------------------------------------------------------------------
// $factoriesCache = new \CodeIgniter\Cache\FactoriesCache();
// $factoriesCache->load('config');

// --------------------------------------------------------------------
// ✅ BUAT INSTANCE APLIKASI CODEIGNITER
// --------------------------------------------------------------------
$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

// --------------------------------------------------------------------
// ✅ JALANKAN APLIKASI
// --------------------------------------------------------------------
$app->run();

// --------------------------------------------------------------------
// ✅ (OPSIONAL) SIMPAN CONFIG CACHE
// --------------------------------------------------------------------
// $factoriesCache->save('config');

// --------------------------------------------------------------------
// ✅ EXIT DENGAN KODE SUKSES
// --------------------------------------------------------------------
exit(EXIT_SUCCESS);
