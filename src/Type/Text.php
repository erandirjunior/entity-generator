<?php

namespace EntityGenerator\Type;

class Text extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'text') {
            $field['length'] = 0;
            return $this->create($field, 'text');
        }

        return $this->dataType->handle($field);
    }
}