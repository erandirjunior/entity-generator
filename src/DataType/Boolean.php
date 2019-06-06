<?php

namespace EntityGenerator\Type;

class Boolean extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'boolean') {
            $this->setAnnotationTypeParameter('boolean');

            return $this->create($field);
        }

        return $this->dataType->handle($field);
    }
}