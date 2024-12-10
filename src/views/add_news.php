<?php
include_once 'layout/header.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<h1 class="text-center mb-4">Добавить новость</h1>

<?php if (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['info_message'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['info_message']; ?></div>
    <?php unset($_SESSION['info_message']); ?>
<?php endif; ?>

<form action="/add-news" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Название</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Описание</label>
        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Фотография</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
        <div class="form-text">Вы можете загрузить несколько изображений (JPG, PNG, GIF и т.д.).</div>
    </div>

    <button type="submit" class="btn btn-primary">Добавить новость</button>
</form>
<?php include_once 'layout/footer.php'; ?>