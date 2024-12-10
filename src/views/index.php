<?php
$page = 'news';
include_once 'layout/header.php';
?>


<h1 class="my-4">Последние новости</h1>

<?php if (empty($newsList)): ?>
    <p>No news available at the moment.</p>
<?php else: ?>
    <!-- Carousel Component -->
    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $newsToShow = array_slice($newsList, 0, 5);
    foreach ($newsToShow as $index => $news):
        if (isset($news['image']) && !empty($news['image'])) {
            $imagePath = '/uploads/' . $news['image'];
        } else {
            $imagePath = '/public/assets/images/default.webp';
        }
        ?>
                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                    <a href="/news/<?php echo $news['id']; ?>" class="text-decoration-none">
                        <img src="<?php echo $imagePath; ?>" class="d-block w-100 img-fluid " alt="News image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $news['title']; ?></h5>
                            <p><?php echo substr($news['content'], 0, 100); ?>...</p>
                            <small>Posted on: <?php echo $news['date']; ?></small>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Carousel Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<?php endif; ?>

<?php include_once 'layout/footer.php'; ?>
