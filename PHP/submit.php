<?php

$dataPath = __DIR__ . '/data';
$dataFile = $dataPath . '/pesan.csv';

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
if ($tipe === '')
    $errors[] = 'Tipe Pesan harus diisi.';
if ($isi === '')
    $errors[] = 'Isi harus diisi.';

if ($errors) {
    echo "<h1>Errors</h1><ul>";
    foreach ($errors as $e) {
        echo '<li>' . htmlspecialchars($e) . '</li>';
    }
    echo "</ul><p><a href=\"daftar.php\">Back</a></p>";
    exit;
}

function appendCSV(array $fields): bool
{
    global $dataFile;
    global $dataPath;
    if (!is_dir($dataPath)) {
        @mkdir($dataPath, 0755, true);
    }

    $needHeader = !file_exists($dataFile);
    $fp = @fopen($dataFile, 'a');
    if (!$fp)
        return false;
    if ($needHeader) {
        fputcsv($fp, ['nama', 'telp', 'tipe_pesan', 'isi', 'submitted_at']);
    }
    if (!flock($fp, LOCK_EX)) {
        fclose($fp);
        return false;
    }
    $ok = fputcsv($fp, $fields) !== false;
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $ok;
}

function prepareCSV($v)
{
    $v = trim($v);
    if ($v !== '' && in_array($v[0], ['=', '+', '-', '@'], true)) {
        return "'" . $v;
    }
    return $v;
}

$record = [
    prepareCSV($nama),
    prepareCSV($telp),
    prepareCSV($tipe),
    prepareCSV($isi),
    date('c')
];

$ok = appendCSV($record);
if ($ok) {
    header('Location: form_success.php');
    exit;
}

echo "<h1>Gagal menyimpan data</h1><p><a href=\"daftar.php\">Back</a></p>";