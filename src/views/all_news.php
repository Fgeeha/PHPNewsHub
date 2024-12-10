<?php
$page = 'news';
include_once 'layout/header.php';
?>

<?php if (empty($newsList)): ?>
    <p>Новостей сейчас нет.</p>
<?php else: ?>
    <div class="row">
        <?php foreach ($newsList as $news): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="/uploads/<?php echo $news['image']; ?>" class="card-img-top" alt="News Image" style="height: 180px; object-fit: cover;">
                    
                    <div class="card-body">
                        <a href="/news/<?php echo $news['id']; ?>" class="text-decoration-none">
                            <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                        </a>
                        <p class="card-text"><?php echo substr(htmlspecialchars($news['content']), 0, 100); ?>...</p>
                        <?php
                        $date = new DateTime($news['date']);
            $date = $date->format('H:i d.m.y');
            ?>
                        <p class="card-text"><small class="text-muted">Дата создания: <?php echo $date; ?></small></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include_once 'layout/footer.php'; ?>