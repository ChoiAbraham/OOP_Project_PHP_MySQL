<?php

// Home Page, mycv.pdf dowload functionality

if (isset($_REQUEST["file"])) {
    // Get parameters
    $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
    $filepath = "files/" . $file;

    // Process download
    if (file_exists($filepath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
    }
}
