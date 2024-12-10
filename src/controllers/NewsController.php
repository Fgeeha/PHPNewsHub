<?php

/**
 * Класс NewsController для управления новостными статьями
 *
 * Этот класс отвечает за отображение, создание, редактирование и удаление новостных статей.
 * Он также позволяет загружать изображения, связанные с новостными статьями.
 *
 * Методы:
 * - __construct($pdo)                   Инициализирует контроллер с помощью подключения PDO.
 * - index()                             Отображает главную страницу со списком всех новостей.
 * - indexShowAllNews()                  Отображает все новости на отдельной странице.
 * - showNewsDetail($id)                 Отображает подробную информацию о конкретной новости.
 * - addImageToNews($newsId, $imagePath) Обновляет существующую новостную статью с помощью изображения.
 * - addNews()                           Отображает форму и обрабатывает создание новостей.
 * - deleteNews($newsId)                 Удаляет конкретную новостную статью.
 * - editNewsForm($newsId)               Отображает форму для редактирования новостной статьи.
 * - updateNews($newsId)                 Обновляет новостную статью с помощью новых данных.
 */

require_once __DIR__ . '/../models/News.php';

class NewsController
{
    /**
     * @var News $news - экземпляр модели News.
     */
    private $news;

    /**
     * Конструктор NewsController.
     *
     * Инициализирует контроллер с помощью предоставленного экземпляра PDO для взаимодействия с базой данных.
     *
     * @param PDO Экземпляр PDO для подключения к базе данных.
     */

    public function __construct($pdo)
    {
        $this->news = new News($pdo);
    }

    /**
     * Displays the home page with a list of all news articles.
     */

    public function index()
    {
        $newsList = $this->news->getAllNews();
        $page = 'home';
        include __DIR__ . '/../views/index.php';
    }

    /**
     * Displays all news articles in a separate page.
     */

    public function indexShowAllNews()
    {
        $newsList = $this->news->getAllNews();
        $page = 'all-news';
        include __DIR__ . '/../views/all_news.php';
    }

    /**
     * Displays the details of a specific news article.
     *
     * @param int $id The ID of the news article.
     */
    public function showNewsDetail($id)
    {
        $newsItem = $this->news->getNewsById($id);
        if (!$newsItem) {
            include __DIR__ . '/../views/view_news_isnt.php';
            return;
        }
        include __DIR__ . '/../views/view_news.php';
    }


    /**
     * Updates a specific news article with an image.
     *
     * @param int $newsId The ID of the news article.
     * @param string $imagePath The path of the image to be added.
     */

    public function addImageToNews($newsId, $imagePath)
    {
        $stmt = $this->pdo->prepare("UPDATE news SET image = :image WHERE id = :id");
        $stmt->bindParam(':id', $newsId, PDO::PARAM_INT);
        $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Displays a form and handles the creation of a new news article.
     */

    public function addNews()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $page = 'news';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['title'], $_POST['content']) && isset($_FILES['images'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];

                $newsId = $this->news->createNews($title, $content);

                $uploadDir = __DIR__ . '/../uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadedImages = [];

                // Обрабатываем все загруженные изображения
                foreach ($_FILES['images']['name'] as $key => $name) {
                    $fileName = basename($name);
                    $targetPath = $uploadDir . $fileName;

                    if (file_exists($targetPath)) {
                        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                        $fileBaseName = basename($fileName, '.' . $fileExt);
                        $newFileName = $fileBaseName . '_' . time() . '.' . $fileExt;
                        $targetPath = $uploadDir . $newFileName;
                    }

                    if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetPath)) {
                        $this->news->addImageToNews($newsId, $fileName);
                        $uploadedImages[] = $targetPath;
                    } else {
                        $errorMessage = "Ошибка загрузки изображения: $name.";
                    }
                }
                $_SESSION['info_message'] = "Добавлена новость: '$title'.";
                header("Location: /add-news");
                exit();
            } else {
                $errorMessage = "Ошибка: не все поля заполнены!";
                include __DIR__ . '/../views/add_news.php';
            }
        } else {
            include __DIR__ . '/../views/add_news.php';
        }
    }

    /**
     * Deletes a specific news article.
     *
     * @param int $newsId The ID of the news article to delete.
     */
    public function deleteNews($newsId)
    {
        $this->news->deleteNews($newsId);

        header("Location: /news");
        exit();
    }

    /**
     * Displays a form for editing an existing news article.
     *
     * @param int $newsId The ID of the news article to edit.
     */
    public function editNewsForm($newsId)
    {
        // Get the current news item by its ID
        $newsItem = $this->news->getNewsById($newsId);
        if ($newsItem) {
            include __DIR__ . '/../views/edit_news.php'; // Show the edit form
        } else {
            echo "Новость не найдена!";
        }
    }

    /**
     * Updates a specific news article.
     *
     * @param int $newsId The ID of the news article.
     */
    public function updateNews($newsId)
    {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image = $_FILES['image'];
        $deleteImage = isset($_POST['delete_image']);

        // Получаем текущую новость из базы данных (чтобы узнать старое изображение)
        $newsItem = $this->news->getNewsById($newsId); // Получаем новость по ID

        // Переменная для хранения пути к изображению
        $imagePath = $newsItem['image']; // По умолчанию ставим старое изображение

        // Проверка на удаление изображения
        if ($deleteImage) {
            // Удаляем изображение, если галочка установлена
            $imagePath = null;
            // Удаляем изображение из файловой системы
            if (file_exists(__DIR__ . '/../uploads/' . $newsItem['image'])) {
                unlink(__DIR__ . '/../uploads/' . $newsItem['image']);
            }
        }

        // Проверка на загрузку нового изображения
        if (isset($image) && $image['error'] == 0 && !$deleteImage) {
            // Путь для загрузки изображений
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($image['name']);
            $targetPath = $uploadDir . $fileName;

            // Если файл существует, переименовываем его
            if (file_exists($targetPath)) {
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileBaseName = basename($fileName, '.' . $fileExt);
                $newFileName = $fileBaseName . '_' . time() . '.' . $fileExt;
                $targetPath = $uploadDir . $newFileName;
                $fileName = $newFileName; // Новый уникальный файл
            }

            // Перемещаем файл в целевую директорию
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                $imagePath = $fileName;  // Обновляем путь к изображению, если оно было загружено
            } else {
                $errorMessage = "Ошибка загрузки изображения: " . $image['name'];
            }
        }

        // Обновляем новость в базе данных, передаем title, content и имя файла изображения
        $this->news->updateNewsModel($newsId, $title, $content, $imagePath);

        // Перенаправляем на страницу с деталями новости
        header("Location: /news/$newsId");
        exit();
    }
}
