<?php

namespace Core\Repository;

use Core\Abstract\RepositoryInterface;
use PDO;
use PDOException;

abstract class MysqlRepository implements RepositoryInterface
{
    protected PDO $pdo;
    protected string $table;
    protected string $modelClass;

    /**
     * Constructor to initialize PDO, table name, and model class.
     *
     * @param PDO $pdo PDO instance used for database operations.
     * @param string $table Table name to perform operations on.
     * @param string $modelClass Fully qualified model class name.
     */
    public function __construct(PDO $pdo, string $table, string $modelClass)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->modelClass = $modelClass;
    }

    /**
     * Fetch all records from the table.
     *
     * @return array List of all records as model instances.
     * @throws \Exception If the query fails.
     */
    public function getAll(): array
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $models = array_map([$this, 'mapRowToModel'], $rows);
            $data = array_map([$this, 'modelToArray'], $models);
            return $data;
        } catch (PDOException $e) {
            throw new \Exception('Failed to fetch all records: ' . $e->getMessage());
        }
    }

    /**
     * Get a record by its ID.
     *
     * @param int $id Record ID.
     * @return object|null Model instance if found, null otherwise.
     */
    public function getById(int $id): ?object
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row === false) {
                return null;
            }

            $model = $this->mapRowToModel($row);
            $data = $this->modelToObject($model);
            return $data;
        } catch (PDOException $e) {
            throw new \Exception('Failed to fetch record by ID: ' . $e->getMessage());
        }
    }

    /**
     * Insert a new record into the table.
     *
     * @param object $model Model instance to insert.
     * @return int The ID of the newly inserted record.
     * @throws \Exception If the insert fails.
     */
    public function insert(object $model): int
    {
        try {
            $data = $this->modelToArray($model);
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
            $stmt->execute($data);
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception('Failed to insert record: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing record in the table.
     *
     * @param object $model Model instance with updated data.
     * @return bool True if the update was successful, false otherwise.
     * @throws \Exception If the update fails.
     */
    public function update(object $model): bool
    {
        try {
            $data = $this->modelToArray($model);
            $id = $data['id'];
            unset($data['id']);

            $sets = [];
            foreach ($data as $key => $value) {
                $sets[] = "$key = :$key";
            }
            $setString = implode(", ", $sets);
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $setString WHERE id = :id");
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw new \Exception('Failed to update record: ' . $e->getMessage());
        }
    }

    /**
     * Delete a record from the table.
     *
     * @param int $id Record ID to delete.
     * @return bool True if the deletion was successful, false otherwise.
     * @throws \Exception If the deletion fails.
     */
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw new \Exception('Failed to delete record: ' . $e->getMessage());
        }
    }

    /**
     * Map a database row to a model instance.
     *
     * @param array $row Database row as an associative array.
     * @return object Instance of the model class.
     */
    protected function mapRowToModel(array $row): object
    {
        // Check if the model class exists
        if (!class_exists($this->modelClass)) {
            throw new \Exception("Model class {$this->modelClass} does not exist.");
        }

        // Create an instance of the model class using reflection
        $reflection = new \ReflectionClass($this->modelClass);
        $model = $reflection->newInstanceWithoutConstructor();

        // Populate the model properties
        foreach ($row as $key => $value) {
            $getter = 'set' . ucfirst($key);
            if ($reflection->hasMethod($getter)) {
                $reflection->getMethod($getter)->invoke($model, $value);
            }
        }

        return $model;
    }

    /**
     * Convert a model instance to an associative array.
     *
     * @param object $model Model instance.
     * @return array Associative array of model properties.
     */
    protected function modelToArray(object $model): array
    {
        // Check if the model class exists
        if (!class_exists($this->modelClass)) {
            throw new \Exception("Model class {$this->modelClass} does not exist.");
        }

        // Create an instance of the model class using reflection
        $reflection = new \ReflectionClass($this->modelClass);

        // Get all methods from the model class
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $data = [];
        foreach ($methods as $method) {
            $methodName = $method->getName();

            // Only consider getter methods
            if (strpos($methodName, 'get') === 0 && $method->getNumberOfParameters() === 0) {
                $property = lcfirst(substr($methodName, 3)); // Remove 'get' prefix and convert to camelCase
                $data[$property] = $method->invoke($model);
            }
        }

        return $data;
    }

    /**
     * Convert a model instance to an associative object.
     *
     * @param object $model Model instance.
     * @return object An object with properties from the model.
     * @throws \Exception If the model class does not exist.
     */
    protected function modelToObject(object $model): object
    {
        // Check if the model class exists
        if (!class_exists(get_class($model))) {
            throw new \Exception("Model class " . get_class($model) . " does not exist.");
        }

        // Create an empty stdClass object
        $object = new \stdClass();

        // Create a reflection instance of the model class
        $reflection = new \ReflectionClass($model);

        // Get all methods from the model class
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            $methodName = $method->getName();

            // Only consider getter methods
            if (strpos($methodName, 'get') === 0 && $method->getNumberOfParameters() === 0) {
                $property = lcfirst(substr($methodName, 3)); // Remove 'get' prefix and convert to camelCase
                $object->$property = $method->invoke($model);
            }
        }

        return $object;
    }
}
