<?php

namespace EntityGenerator\DataType;

class Id extends DataType
{
	private $dataBaseType;

	public function __construct($className, $dataBaseType)
	{
		parent::__construct($className);
		$this->dataBaseType = $dataBaseType;
	}

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
         * @ORM\GeneratedValue(strategy="'.$this->dataBaseType.'")
         */
         private $'.$this->attibuteName.';';
    }
}