<?php
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review - Park Shanghai</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&family=Onest:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sticky-header">
        <img src="src/header-top.png" class="header-top" alt="Header">
    </div>

    <h2 style="justify-self: center; color: #a72023ff; margin-top: 40px;">BERIKAN REVIEW ANDA</h2>
    
    <form action="submit_review.php" method="post" enctype="multipart/form-data" style="align-self: center; justify-self: center; font-family: 'Lato', sans-serif; font-weight: 800; width: 70%; margin-bottom: 50px;">
        
        <label>Nama<br>
            <input type="text" name="nama" required maxlength="255" style="height: 30px; width: 100%; background-color: #dadabeff; border: 2px solid #bdbba7ff; border-radius: 10px; padding: 5px;">
        </label>
        <br><br>

        <label>Rating (1-5 Bintang)<br>
            <select name="rating" required style="height: 40px; width: 100%; background-color: #dadabeff; border: 2px solid #bdbba7ff; border-radius: 10px; padding: 5px;">
                <option value="">--Pilih Rating--</option>
                <option value="5">⭐⭐⭐⭐⭐ (5 Bintang)</option>
                <option value="4">⭐⭐⭐⭐ (4 Bintang)</option>
                <option value="3">⭐⭐⭐ (3 Bintang)</option>
                <option value="2">⭐⭐ (2 Bintang)</option>
                <option value="1">⭐ (1 Bintang)</option>
            </select>
        </label>
        <br><br>
        
        <label>Review Anda<br>
            <textarea name="review" required maxlength="1000" rows="6" style="width: 100%; background-color: #dadabeff; border: 2px solid #bdbba7ff; border-radius: 10px; padding: 10px; font-family: 'Lato', sans-serif; resize: vertical;"></textarea>
        </label>
        <br><br>

        <label>Upload Foto (Opsional)<br>
            <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png" style="width: 100%; padding: 10px; background-color: #dadabeff; border: 2px solid #bdbba7ff; border-radius: 10px;">
            <small style="color: #666; font-weight: 400;">Format: JPG, JPEG, PNG. Maksimal 5MB</small>
        </label>
        <br><br><br>

        <button type="submit" style="height: 60px; width: 100%; background-color: #f1f1dcff; border: 2px solid #bdbba7ff; border-radius: 10px; cursor: pointer;">
            <p style="font-weight: 600; font-size: large; margin: 0;">Kirim Review</p>
        </button>
        <br><br>
        <p style="text-align: center; font-weight: 400;"><a href="index_db.php" style="color: #a72023ff;">Kembali ke Halaman Utama</a></p>
    </form>

    <div class="image-container-1" style="width: 100vw; bottom: 0;">
        <img src="src/bar-bottom.png" alt="header" class="header-bottom" style="width: 100vw; top: 0; justify-content: center;">
        <div class="text-overlay" style="left: 15%; top: 11%; max-width: 65%;">
            <p>© 2025 Park Shanghai</p>
            <p><a href="https://www.pakuwoncity.com/mall/" style="color: #e789aaff;" target="_blank">Website Pakuwon City Mall</a></p>
        </div>
    </div>
</body>
</html>