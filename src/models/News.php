<?php

/**
 * Класс для работы с новостями в базе данных.
 *
 * Этот класс инкапсулирует все операции с базой данных, связанные с новостями:
 * создание новостей, обновление, удаление, а также получение списка новостей и одной новости по ID.
 */

class News
{
    /**
     * @var PDO $pdo Экземпляр соединения с базой данных через PDO.
     */

    private $pdo;

    /**
     * Конструктор класса News.
     *
     * @param PDO $pdo Экземпляр подключения к базе данных.
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Получает все новости из базы данных.
     *
     * Запрашивает список новостей, отсортированных по дате в убывающем порядке.
     *
     * @return array Массив всех новостей.
     */
    public function getAllNews()
    {
        $stmt = $this->pdo->query("SELECT * FROM news ORDER BY date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получает новость по её ID.
     *
     * Запрашивает одну новость из базы данных по её уникальному ID.
     *
     * @param int $id ID новости.
     * @return array|null Возвращает ассоциативный массив с данными новости, если она найдена,
     *                    или null, если новость не найдена.
     */
    public function getNewsById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Создаёт новую новость в базе данных.
     *
     * Вставляет новую запись в таблицу новостей с переданными значениями заголовка и содержания.
     * Дата добавления новости устанавливается автоматически.
     *
     * @param string $title Заголовок новости.
     * @param string $content Содержание новости.
     * @return int ID новой новости.
     */
    public function createNews($title, $content)
    {
        $stmt = $this->pdo->prepare("INSERT INTO news (title, content, date) VALUES (:title, :content, NOW())");
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    /**
     * Обновляет существующую новость.
     *
     * Обновляет заголовок, содержание и изображение новости по её ID.
     *
     * @param int $id ID новости для обновления.
     * @param string $title Новый заголовок новости.
     * @param string $content Новое содержание новости.
     * @param string $image Новый путь к изображению новости.
     */
    public function updateNewsModel($id, $title, $content, $image)
    {
        $stmt = $this->pdo->prepare("UPDATE news SET title = :title, content = :content, image = :image WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Удаляет новость из базы данных.
     *
     * Удаляет запись новости по её ID.
     *
     * @param int $id ID новости для удаления.
     */
    public function deleteNews($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Добавляет изображение к новости.
     *
     * Обновляет запись новости, добавляя путь к изображению.
     *
     * @param int $newsId ID новости, к которой добавляется изображение.
     * @param string $imagePath Путь к изображению.
     */
    public function addImageToNews($newsId, $imagePath)
    {
        $stmt = $this->pdo->prepare("UPDATE news SET image = :image WHERE id = :id");
        $stmt->bindParam(':id', $newsId, PDO::PARAM_INT);
        $stmt->bindParam(':image', $imagePath, PDO::PARAM_STR);
        $stmt->execute();
    }
}
