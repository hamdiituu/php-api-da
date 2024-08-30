<?php

namespace Core\Abstract;

interface RepositoryInterface
{
    /**
     * Fetch all records from the repository.
     *
     * @return array List of all records as model instances.
     */
    public function getAll(): array;

    /**
     * Get a record by its ID.
     *
     * @param int $id Record ID.
     * @return object|null Model instance if found, null otherwise.
     */
    public function getById(int $id): ?object;

    /**
     * Insert a new record into the repository.
     *
     * @param object $model Model instance to insert.
     * @return int The ID of the newly inserted record.
     */
    public function insert(object $model): int;

    /**
     * Update an existing record in the repository.
     *
     * @param object $model Model instance with updated data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(object $model): bool;

    /**
     * Delete a record from the repository.
     *
     * @param int $id Record ID to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function delete(int $id): bool;
}