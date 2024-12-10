<?php include_once 'layout/header.php'; ?>

<div class="container mt-4">
    <!-- Карточка для отображения новости -->
    <div class="card shadow-sm">
        <img src="/uploads/<?php echo $newsItem['image']; ?>" class="card-img-top" alt="News Image">
        <div class="card-body">
            <h1 class="card-title"><?php echo htmlspecialchars($newsItem['title']); ?></h1>
            <p class="card-text"><?php echo nl2br(htmlspecialchars($newsItem['content'])); ?></p>
            <a href="/news" class="btn btn-primary">Вернуться к списку новостей</a>

            <a href="/edit-news/<?php echo $newsItem['id']; ?>" class="btn btn-warning">Изменить</a>

            <form action="/delete-news/<?php echo $newsItem['id']; ?>" method="POST" style="display:inline;">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить эту новость?');">Удалить</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'layout/footer.php'; ?>
