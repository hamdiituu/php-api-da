<?php

namespace Http\Validators;

class TodoCreateValidator
{
    public static function validate(array $data): array
    {
        $errors = [];

        if (empty($data['title']) || !is_string($data['title'])) {
            $errors[] = 'Title is required and must be a string.';
        }

        if (empty($data['description']) || !is_string($data['description'])) {
            $errors[] = 'Description is required and must be a string.';
        }

        if (!isset($data['completed']) || !is_bool($data['completed'])) {
            $errors[] = 'Completed must be a boolean.';
        }

        return $errors;
    }
}