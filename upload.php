<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $targetDir = "assets/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (!isset($_FILES["file"])) {
        $result = "Field 'file' tidak ditemukan.";
    } else {
        $fileInfo = $_FILES["file"];
        $fileName = basename($fileInfo["name"]);
        $tmpName  = $fileInfo["tmp_name"];
        $error    = $fileInfo["error"];
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($ext !== 'glb') {
            $result = "Hanya file .glb yang diperbolehkan.";
        } else {
            $newName = time() . "_" . $fileName;
            $targetPath = $targetDir . $newName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $result = "File berhasil disimpan di <strong>$targetPath</strong><br>" .
                          "<a href='$targetPath' target='_blank'>Lihat File</a>";
            } else {
                $result = "Gagal menyimpan file";
            }
        }
    }

    echo "<div style='padding:1em;background:#f0f0f0;border-radius:6px;'>$result</div>";
}
?>
