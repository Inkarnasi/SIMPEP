<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig(__DIR__ . '/credentials/credentials.json');
$client->addScope(Google\Service\Drive::DRIVE);
$client->setAccessType('offline'); // penting agar dapat refresh_token
$client->setPrompt('consent');     // paksa Google beri refresh_token

$redirectUri = 'http://localhost/SIMPEP/oauth2callback.php';
$client->setRedirectUri($redirectUri);

$authUrl = $client->createAuthUrl();

echo "Buka URL ini di browser untuk mendapatkan kode authorization:<br>";
echo "<a href='" . htmlspecialchars($authUrl) . "' target='_blank'>Login ke Google Drive</a>";
