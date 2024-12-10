<?php

/**
 * Класс для подключения к базе данных
 *
 * Этот класс инкапсулирует логику подключения к базе данных
 * и предоставляет метод для получения соединения через PDO.
 */
class Database
{
    private static $instance = null;
    private $pdo;

    /**
     * Конструктор для подключения к базе данных
     *
     * Устанавливает соединение с PostgreSQL базой данных с использованием PDO.
     * Если подключение не удается, выводится ошибка.
     */
    private function __construct()
    {
        $host = 'db';
        $dbname = 'news_db';
        $user = 'news_user';
        $password = 'news_password';
        $port = '5432';

        try {
            $this->pdo = new PDO(
                "pgsql:host={$host};port={$port};dbname={$dbname}",
                $user,
                $password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Возвращает экземпляр подключения (Singleton).
     *
     * @return Database Экземпляр класса Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    /**
     * Получить соединение с базой данных
     *
     * @return PDO Возвращает объект PDO, который используется для выполнения запросов к базе данных.
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}
