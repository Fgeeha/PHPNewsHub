<?php
$page = 'add-news';
include_once 'layout/header.php';
?>

<h1>Редактировать новость</h1>

<?php if (isset($errorMessage)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $errorMessage; ?>
    </div>
<?php } ?>

<form action="/edit-news/<?php echo $newsItem['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title mb-4 text-center">Редактировать новость</h3>

                        <!-- Title input -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Название:</label>
                            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($newsItem['title']); ?>" required>
                        </div>

                        <!-- Content textarea -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Содержание:</label>
                            <textarea name="content" id="content" class="form-control" required><?php echo htmlspecialchars($newsItem['content']); ?></textarea>
                        </div>

                        <!-- Display current image if exists -->
                        <?php if (!empty($newsItem['image'])): ?>
                            <div class="mb-3">
                                <p>Текущее изображение:</p>
                                <img src="/uploads/<?php echo $newsItem['image']; ?>" alt="Current Image" class="img-thumbnail" style="max-width: 100px;">
                            </div>
                        <?php endif; ?>

                        <!-- Image upload input -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Изображение (оставьте пустым, если не хотите менять):</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        
                        <!-- Checkbox to delete image -->
                        <?php if (!empty($newsItem['image'])): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image">
                                <label class="form-check-label" for="delete_image">
                                    Удалить изображение
                                </label>
                            </div>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Обновить новость</button>
                            <a href="/news/<?php echo $newsItem['id']; ?>" class="btn btn-secondary">Отмена</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include_once 'layout/footer.php'; ?>
