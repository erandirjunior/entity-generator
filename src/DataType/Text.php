<?php

namespace EntityGenerator\DataType;

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
            $this->setAnnotationTypeParameter('string');

            return $this->create($field);
        }

        return $this->dataType->handle($field);
    }
}