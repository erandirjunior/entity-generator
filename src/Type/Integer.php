<?php

namespace EntityGenerator\Type;

class Integer extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'integer') {
            return $this->create($field, 'string');
        }

        return $this->dataType->handle($field);
    }
}