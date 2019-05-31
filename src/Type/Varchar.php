<?php

namespace EntityGenerator\Type;

class Varchar extends DataType implements Type
{
    private $dataType;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'varchar') {
            $this->setAnnotationTypeParameter('string');
            $field['type'] = 'string';

            return $this->create($field);
        }

        return $this->dataType->handle($field);
    }
}
