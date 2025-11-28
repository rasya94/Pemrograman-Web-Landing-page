<?php

$dataPath = __DIR__ . '/data';
$reviewFile = $dataPath . '/reviews.csv';

$reviews = [];
if (file_exists($reviewFile)) {
    $fp = fopen($reviewFile, 'r');
    if ($fp) {
        $headers = fgetcsv($fp); 
        while (($row = fgetcsv($fp)) !== false) {
            if (count($row) >= 5) {
                $reviews[] = [
                    'nama' => $row[0],
                    'rating' => (int)$row[1],
                    'review' => $row[2],
                    'foto' => $row[3],
                    'submitted_at' => $row[4]
                ];
            }
        }
        fclose($fp);
    }
}

$reviews = array_reverse($reviews);

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
    <style>
        .review-container {
            width: 80%;
            margin: 20px auto;
            max-width: 1000px;
        }
        
        .review-card {
            background-color: white;
            border: 2px solid #bdbba7ff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .reviewer-name {
            font-weight: 700;
            font-size: 18px;
            color: #a72023ff;
        }
        
        .rating {
            color: #FFD700;
            font-size: 20px;
        }
        
        .review-text {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #333;
        }
        
        .review-photo {
            max-width: 100%;
            max-height: 400px;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .review-date {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
        
        .add-review-btn {
            display: inline-block;
            padding: 15px 40px;
            background-color: #a72023ff;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            margin: 20px 0;
        }
        
        .add-review-btn:hover {
            background-color: #8a1a1c;
        }
        
        .no-reviews {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="sticky-header">
        <img src="src/header-top.png" class="header-top" alt="Header">
    </div>

    <h2 style="text-align: center; color: #a72023ff; margin-top: 40px;">REVIEW PENGUNJUNG</h2>
    
    <div style="text-align: center;">
        <a href="review.php" class="add-review-btn">+ Tambah Review Anda</a>
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