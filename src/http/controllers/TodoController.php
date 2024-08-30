<?php

namespace Http\Controllers;

use Core\Controller;
use Data\Repositories\TodoRepository;
use Data\Models\Todo;
use Http\Validators\TodoCreateValidator;

class TodoController extends Controller
{
    private $repository;

    /**
     * Constructor to initialize TodoRepository.
     *
     * @param TodoRepository $repository TodoRepository instance.
     */
    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all todos.
     */
    public function getAll()
    {
        try {
            $todos = $this->repository->getAll();
            $this->jsonResponse($todos);
        } catch (\Exception $e) {
            $this->internalServerError($e->getMessage());
        }
    }

    /**
     * Get a todo by its ID.
     *
     * @param int $id Todo ID.
     */
    public function getById($id)
    {
        try {
            $todo = $this->repository->getById((int)$id);
            if ($todo) {
                $this->jsonResponse($todo);
            } else {
                $this->notFound("Todo with ID $id not found");
            }
        } catch (\Exception $e) {
            $this->internalServerError($e->getMessage());
        }
    }

    /**
     * Create a new todo.
     */
    public function create()
    {
        $data = $this->getJsonData();

        $errors = TodoCreateValidator::validate($data);

        if (!empty($errors)) {
            $this->badRequest(['errors' => $errors], 400);
            return;
        }

        try {
            $todo = new Todo();
            $todo->setTitle($data['title']);
            $todo->setDescription($data['description']);
            $todo->setCompleted($data['completed']);

            $id = $this->repository->insert($todo);
            $this->created(['id' => $id], 201); // 201 Created
        } catch (\Exception $e) {
            $this->internalServerError($e->getMessage());
        }
    }

    /**
     * Update an existing todo.
     *
     * @param int $id Todo ID.
     */
    public function update($id)
    {
        $data = $this->getJsonData();
        try {
            $todo = $this->repository->getById((int)$id);
            if ($todo) {
                if (isset($data['title'])) {
                    $todo->setTitle($data['title']);
                }
                if (isset($data['completed'])) {
                    $todo->setCompleted($data['completed']);
                }

                $this->repository->update($todo);
                $this->jsonResponse(['message' => 'Todo updated successfully']);
            } else {
                $this->notFound("Todo with ID $id not found");
            }
        } catch (\Exception $e) {
            $this->internalServerError($e->getMessage());
        }
    }

    /**
     * Delete a todo by its ID.
     *
     * @param int $id Todo ID.
     */
    public function delete($id)
    {
        try {
            $deleted = $this->repository->delete((int)$id);
            if ($deleted) {
                $this->jsonResponse(['message' => 'Todo deleted successfully']);
            } else {
                $this->notFound("Todo with ID $id not found");
            }
        } catch (\Exception $e) {
            $this->internalServerError($e->getMessage());
        }
    }
}
