<?php

namespace EntityGenerator\Type;

class Text extends Field implements Type
{
    private $type;

    public function next(Type $type)
    {
        $this->type = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'text') {
            return $this->mountAttribute($field);
        }

        return $this->type->handle($field);
    }

    public function mountAttribute($field)
    {
        return $this->createAttribute($field, 'string');
    }
}