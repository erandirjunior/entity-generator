<?php

namespace EntityGenerator\Type;

class Varchar implements Type
{
    private $type;

    public function next(Type $type)
    {
        $this->type = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'varchar') {
            return $this->mountAttribute($field);
        }

        return $this->type->handle($field);
    }

    private function mountAttribute($field)
    {
        var_dump($field);
    }
}