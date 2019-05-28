<?php

namespace EntityGenerator\Type;

class Integer implements Type
{
    private $type;

    public function next(Type $type)
    {
        $this->type = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'integer') {
            return $this->mountAttribute($field);
        }

        return $this->type->handle($field);
    }

    private function mountAttribute($field)
    {

    }
}