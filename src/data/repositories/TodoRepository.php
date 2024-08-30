<?php

namespace Data\Repositories;

use PDO;
use PDOException;
use Core\Repository\MysqlRepository;
use Data\Models\Todo;

class TodoRepository extends MysqlRepository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, 'todos', Todo::class);
    }

    public function getCompletedTodos(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table} WHERE completed = 1");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \Exception('Failed to fetch completed todos: ' . $e->getMessage());
        }
    }
}
