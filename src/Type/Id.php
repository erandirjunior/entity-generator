<?php

namespace EntityGenerator\Type;

class Id extends DataType
{
    public function createId()
    {
        $this->setColumnType('integer');
        $this->setColumnName('id');
        $this->setAnnotationTypeParameter('int');
        $this->convertUnderscoreToCamelCase('id');

        $attribute  = $this->createAttribute();
        $method     = $this->createGetMethod('int');

        return [
            'attribute' => $attribute,
            'methods'   => $method,
        ];
    }

    protected function createAttribute()
    {
        return '/**
         * @var '.implode('|', $this->annotationTypeParameter).'
         *
         * @ORM\Column('.$this->columnName.', '.$this->columnType.', '.$this->nullable.')
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="")
         */
         private $'.$this->attibuteName.';';
    }
}