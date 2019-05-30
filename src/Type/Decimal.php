<?php

namespace EntityGenerator\Type;

class Decimal extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'decimal') {
            return $this->create($field, 'string');
        }

        return $this->dataType->handle($field);
    }
}