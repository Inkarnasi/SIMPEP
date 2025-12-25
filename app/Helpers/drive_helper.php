<?php


if (!function_exists('getDriveFileId')) {
    function getDriveFileId($url)
    {
        // Tangkap ID file dari berbagai format URL
        if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return $matches[1];
        }
        if (preg_match('/[-\w]{25,}/', $url, $matches)) {
            return $matches[0];
        }
        return null;
    }
}


if (!function_exists('getDriveViewLink')) {
    function getDriveViewLink($url)
    {
        $id = getDriveFileId($url);
        return $id ? "https://drive.google.com/uc?export=view&id={$id}" : $url;
    }
}

if (!function_exists('getDriveDownloadLink')) {
    function getDriveDownloadLink($url)
    {
        $id = getDriveFileId($url);
        return $id ? "https://drive.google.com/uc?export=download&id={$id}" : $url;
    }
}
