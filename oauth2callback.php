<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/credentials/credentials.json');
$client->addScope(Google\Service\Drive::DRIVE);
$client->setAccessType('offline');
$client->setRedirectUri('http://localhost/SIMPEP/oauth2callback.php');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        echo "Error saat ambil token: " . htmlspecialchars($token['error']);
        exit;
    }

    // simpan token ke credentials/token.json
    $tokenPath = __DIR__ . '/credentials/token.json';
    file_put_contents($tokenPath, json_encode($token));

    echo "✅ Token berhasil disimpan ke: <b>$tokenPath</b><br>";
    echo "Sekarang kamu bisa kembali ke aplikasi web dan coba upload lagi.";
} else {
    echo "Tidak ada kode authorization. Jalankan getToken.php terlebih dahulu.";
}
