<?php
require_once 'config.php';

try {
    $pdo = getDBConnection();
    
    $sql = "SELECT * FROM reviews ORDER BY submitted_at DESC";
    $stmt = $pdo->query($sql);
    $reviews = $stmt->fetchAll();
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pengunjung - Park Shanghai</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&family=Onest:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="sticky-header">
        <img src="src/header-top.png" class="header-top" alt="Header">
    </div>

    <h2 style="text-align: center; color: #a72023ff; margin-top: 40px;">REVIEW PENGUNJUNG</h2>
    
    <div style="text-align: center;">
        <a href="review_db.php" class="add-review-btn">+ Tambah Review Anda</a>
    </div>

    <div class="review-container">
        <?php if (empty($reviews)): ?>
            <div class="no-reviews">
                <p style="font-size: 18px;">Belum ada review. Jadilah yang pertama memberikan review!</p>
            </div>
        <?php else: ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="review-card">
                    <div class="review-header">
                        <div class="reviewer-name"><?php echo htmlspecialchars($rev['nama']); ?></div>
                        <div class="rating">
                            <?php 
                            for ($i = 0; $i < $rev['rating']; $i++) {
                                echo '⭐';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="review-text">
                        <?php echo nl2br(htmlspecialchars($rev['review'])); ?>
                    </div>
                    
                    <?php if (!empty($rev['foto'])): ?>
                        <div>
                            <img src="uploads/<?php echo htmlspecialchars($rev['foto']); ?>" 
                                 alt="Review photo" 
                                 class="review-photo">
                        </div>
                    <?php endif; ?>
                    
                    <div class="review-date">
                        <?php 
                        $date = new DateTime($rev['submitted_at']);
                        echo $date->format('d F Y, H:i');
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div style="text-align: center; margin: 40px 0;">
        <a href="index_db.php" style="color: #a72023ff; text-decoration: underline; font-size: 16px;">Kembali ke Halaman Utama</a>
    </div>

    <div class="image-container-1" style="width: 100vw; margin-top: 50px;">
        <img src="src/bar-bottom.png" alt="header" class="header-bottom" style="width: 100vw; top: 0; justify-content: center;">
        <div class="text-overlay" style="left: 15%; top: 11%; max-width: 65%;">
            <p>© 2025 Park Shanghai</p>
            <p><a href="https://www.pakuwoncity.com/mall/" style="color: #e789aaff;" target="_blank">Website Pakuwon City Mall</a></p>
        </div>
    </div>
</body>
</html>