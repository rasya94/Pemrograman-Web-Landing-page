<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nama = trim((string) ($_POST['nama'] ?? ''));
$telp = trim((string) ($_POST['telp'] ?? ''));
$tipe = trim((string) ($_POST['tipe'] ?? ''));
$isi = trim((string) ($_POST['isi'] ?? ''));

$errors = [];
if ($nama === '')
    $errors[] = 'Nama harus diisi.';
if ($telp === '')
    $errors[] = 'No. telpon harus diisi.';
if ($tipe === '' || !in_array($tipe, ['Keluhan', 'Pertanyaan', 'Lainnya']))
    $errors[] = 'Tipe Pesan harus diisi dengan benar.';
if ($isi === '')
    $errors[] = 'Isi harus diisi.';

if ($errors) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Park Shanghai</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&family=Onest:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body style="padding: 40px;">
    <h1 style="color: #a72023ff;">Errors</h1><ul>';
    foreach ($errors as $e) {
        echo '<li>' . htmlspecialchars($e) . '</li>';
    }
    echo '</ul><p><a href="index_db.php" style="color: #a72023ff;">Back</a></p>
</body>
</html>';
    exit;
}

try {
    $pdo = getDBConnection();
    
    $sql = "INSERT INTO pesan (nama, telp, tipe_pesan, isi) VALUES (:nama, :telp, :tipe_pesan, :isi)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nama' => $nama,
        ':telp' => $telp,
        ':tipe_pesan' => $tipe,
        ':isi' => $isi
    ]);
    
    header('Location: form_success.php');
    exit;
    
} catch (PDOException $e) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Park Shanghai</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&family=Onest:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body style="padding: 40px;">
    <h1 style="color: #a72023ff;">Gagal menyimpan data</h1>
    <p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>
    <p><a href="index_db.php" style="color: #a72023ff;">Back</a></p>
</body>
</html>';
}
?>