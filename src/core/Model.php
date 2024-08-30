<?php

namespace Core;

abstract class Model
{
    /**
     * Convert model properties to an associative array.
     *
     * @return array Associative array of model properties.
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Create an instance of the model from an associative array.
     *
     * @param array $data Associative array of model properties.
     * @return static Instance of the model.
     */
    public static function fromArray(array $data): self
    {
        $reflection = new \ReflectionClass(static::class);
        $instance = $reflection->newInstanceWithoutConstructor();

        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($instance, $setter)) {
                $instance->$setter($value);
            }
        }

        return $instance;
    }
}
