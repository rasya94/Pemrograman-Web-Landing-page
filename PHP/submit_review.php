<?php

$dataPath = __DIR__ . '/data';
$reviewFile = $dataPath . '/reviews.csv';
$uploadPath = __DIR__ . '/uploads';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: review.php');
    exit;
}

$nama = trim((string) ($_POST['nama'] ?? ''));
$rating = trim((string) ($_POST['rating'] ?? ''));
$review = trim((string) ($_POST['review'] ?? ''));

$errors = [];
if ($nama === '')
    $errors[] = 'Nama harus diisi.';
if ($rating === '' || !in_array($rating, ['1', '2', '3', '4', '5']))
    $errors[] = 'Rating harus dipilih (1-5).';
if ($review === '')
    $errors[] = 'Review harus diisi.';

$fotoFilename = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['foto'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $maxSize = 5 * 1024 * 1024; 
        if (!in_array($file['type'], $allowedTypes)) {
            $errors[] = 'Format foto harus JPG, JPEG, atau PNG.';
        } elseif ($file['size'] > $maxSize) {
            $errors[] = 'Ukuran foto maksimal 5MB.';
        } else {
            if (!is_dir($uploadPath)) {
                @mkdir($uploadPath, 0755, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fotoFilename = uniqid('review_') . '.' . $extension;
            $targetPath = $uploadPath . '/' . $fotoFilename;
            
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $errors[] = 'Gagal mengupload foto.';
                $fotoFilename = null;
            }
        }
    } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Terjadi kesalahan saat upload foto.';
    }
}

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
    echo '</ul><p><a href="review.php" style="color: #a72023ff;">Kembali</a></p>
</body>
</html>';
    exit;
}

function appendReviewCSV(array $fields): bool
{
    global $reviewFile;
    global $dataPath;
    if (!is_dir($dataPath)) {
        @mkdir($dataPath, 0755, true);
    }

    $needHeader = !file_exists($reviewFile);
    $fp = @fopen($reviewFile, 'a');
    if (!$fp)
        return false;
    if ($needHeader) {
        fputcsv($fp, ['nama', 'rating', 'review', 'foto', 'submitted_at']);
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
    $rating,
    prepareCSV($review),
    $fotoFilename ?? '',
    date('c')
];

$ok = appendReviewCSV($record);
if ($ok) {
    header('Location: review_success.php');
    exit;
}

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
    <h1 style="color: #a72023ff;">Gagal menyimpan review</h1>
    <p><a href="review.php" style="color: #a72023ff;">Kembali</a></p>
</body>
</html>';