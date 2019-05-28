<?php

namespace EntityGenerator\Type;

class Datetime implements Type
{
    private $type;

    public function next(Type $type)
    {
        $this->type = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'datetime' || $field['type'] === 'date') {
            return $this->mountAttribute($field);
        }

        return $this->type->handle($field);
    }

    private function mountAttribute($field)
    {

    }
}