<?php


/**
 * Главный файл для маршрутизации запросов и отображения новостей.
 *
 * Этот файл отвечает за обработку запросов, определение маршрутов и вызов соответствующих
 * методов контроллера для обработки новостей. Также отвечает за подключение к базе данных
 * и отображение страницы в зависимости от запроса.
 */

// Подключаем необходимые файлы для работы с базой данных, моделями и контроллерами
require_once 'config/database.php';  // Database configuration and connection
require_once __DIR__ . '/models/News.php'; // News model for database queries
require_once __DIR__ . '/controllers/NewsController.php'; // News controller for handling requests

// Инициализация подключения к базе данных
$db = Database::getInstance();
$pdo = $db->getConnection();

// Инициализация контроллера новостей
$controller = new NewsController($pdo);

// Получаем текущий URI запроса
$request_uri = $_SERVER['REQUEST_URI'];

// Логика маршрутизации в зависимости от URI запроса
if ($request_uri == '/' || $request_uri == '/index.php') {
    // Если URI соответствует главной странице или index.php, показываем все новости
    $controller->index();
} elseif ($request_uri == '/news') {
    // Если URI это /news, показываем список всех новостей
    $controller->indexShowAllNews();
} elseif (preg_match('/^\/news\/(\d+)$/', $request_uri, $matches)) {
    // Если URI соответствует конкретной новости (/news/{id}), показываем детализированную информацию
    $newsId = $matches[1];
    $controller->showNewsDetail($newsId);

} elseif (preg_match('/^\/edit-news\/(\d+)$/', $request_uri, $matches)) {
    // Если URI соответствует редактированию новости (/edit-news/{id}), обрабатываем редактирование
    $newsId = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Обработка обновления новости
        $controller->updateNews($newsId);
    } else {
        // Показываем форму редактирования
        $controller->editNewsForm($newsId);
    }

} elseif (preg_match('/^\/delete-news\/(\d+)$/', $request_uri, $matches)) {
    // Если URI соответствует удалению новости (/delete-news/{id}), обрабатываем удаление
    $newsId = $matches[1];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $controller->deleteNews($newsId);
    }

} elseif ($request_uri == '/news_add' || $request_uri == '/views/news_add.php') {
    // Если URI соответствует /news_add, показываем страницу добавления новости (эта логика кажется избыточной)
    $controller->showNewsDetail($newsId);
} elseif ($request_uri == '/add-news') {
    // Если URI это /add-news, обрабатываем добавление новой новости
    $controller->addNews();
} else {
    // Если не найдено соответствий маршруту, показываем ошибку 404
    header("HTTP/1.0 404 Not Found");
    require_once __DIR__ .'/views/layout/header.php';
    echo "<h1>404 Not Found</h1>";
    echo "<h2>Страница не найдена!</h2>";
    echo "<h3>Вернуть, пожалуйста, обратно.</h3>";
    require_once __DIR__ .'/views/layout/footer.php';
}
