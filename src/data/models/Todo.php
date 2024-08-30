<?php

namespace Data\Models;

use Core\Model;

class Todo extends Model
{
    private $id;
    private $title;
    private $description;
    private $completed;

    /**
     * Get the ID of the todo item.
     *
     * @return int|null The ID of the todo item.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the ID of the todo item.
     *
     * @param int $id The ID to set.
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the title of the todo item.
     *
     * @return string|null The title of the todo item.
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the title of the todo item.
     *
     * @param string $title The title to set.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the description of the todo item.
     *
     * @return string|null The description of the todo item.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the description of the todo item.
     *
     * @param string $description The description to set.
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the completion status of the todo item.
     *
     * @return bool|null The completion status of the todo item.
     */
    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    /**
     * Set the completion status of the todo item.
     *
     * @param bool $completed The completion status to set.
     */
    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }
}
