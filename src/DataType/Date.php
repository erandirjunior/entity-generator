<?php

namespace EntityGenerator\Type;

class Date extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'date') {
            $this->setAnnotationTypeParameter('\Datetime');

            return $this->create($field);
        }

        return $this->dataType->handle($field);
    }
}