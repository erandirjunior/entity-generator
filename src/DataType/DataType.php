<?php

namespace EntityGenerator\DataType;

abstract class DataType
{
    protected $nullable;

    protected $nullableParameter;

    protected $columnName;

    protected $options;

    protected $columnType;

    protected $columnLength;

    protected $attibuteName;

    protected $annotationTypeParameter;

    protected $className;

    public function __construct($className)
    {
        $this->nullable                 = 'nullable=false';
        $this->nullableParameter        = '';
        $this->columnName               = '';
        $this->options                  = '';
        $this->columnType               = '';
        $this->columnLength             = '';
        $this->attibuteName             = '';
        $this->annotationTypeParameter  = [];
        $this->className                = $className;
    }

    protected function setNullable($nullable)
    {
        if ($nullable === 'y') {
            $this->nullable = 'nullable=true';
            $this->nullableParameter = ' = null';
            $this->annotationTypeParameter[] = 'null';
        }
    }

    protected function setColumnName($name)
    {
        $this->columnName = "name=\"{$name}\"";
    }

    protected function setColumnType($columnType)
    {
        $this->columnType = "type=\"{$columnType}\"";
    }

    protected function setColumnLength($field)
    {
        if (!empty($field['length'])) {
            $this->columnLength = "length={$field['length']}, ";
        }
    }

    protected function setAnnotationTypeParameter($type)
    {
        $this->annotationTypeParameter[] = $type;
    }

    protected function create($field)
    {
        $this->convertUnderscoreToCamelCase($field['name']);
        $this->setNullable($field['nullable']);
        $this->setColumnName($field['name']);
        $this->setColumnType($field['type']);
        $this->setColumnLength($field);

        $attribute  = $this->createAttribute();
        $methods    = $this->createMethods();

        return [
            'attribute' => $attribute,
            'methods'   => $methods,
        ];
    }

    protected function createAttribute()
    {
        return '
        
        /**
         * @var '.implode('|', $this->annotationTypeParameter).'
         *
         * @ORM\Column('.$this->columnName.', '.$this->columnType.', '.$this->columnLength.$this->nullable.')
         */
         private $'.$this->attibuteName.';';
    }

    protected function createMethods()
    {
        return $this->createSetMethod().$this->createGetMethod();
    }

    protected function createSetMethod()
    {
        return '
        
        /**
         * Set '.$this->attibuteName.'.
         *
         * @param '.implode('|', $this->annotationTypeParameter).' $'.$this->attibuteName.'
         *
         * @return '.$this->className.'
         */
        public function set'.ucfirst($this->attibuteName).'($'.$this->attibuteName.$this->nullableParameter.')
        {
            $this->'.$this->attibuteName.' = $'.$this->attibuteName.';
    
            return $this;
        }';
    }

    protected function createGetMethod()
    {
        return '
        
        /**
         * Get '.$this->attibuteName.'.
         *
         * @return '.implode('|', $this->annotationTypeParameter).' $'.$this->attibuteName.'
         */
        public function get'.ucfirst($this->attibuteName).'()
        {
            return $this->'.$this->attibuteName.';
        }';
    }

    protected function convertUnderscoreToCamelCase($attribute)
    {
        $atrributeArray = explode('_', $attribute);
        $pieces = [];

        foreach ($atrributeArray as $k => $v) {
            if ($k === 0) {
                $pieces[] = $v;

                continue;
            }

            $pieces[] = ucfirst($v);
        }

        $this->attibuteName = $pieces ? implode('', $pieces) : $attribute;
    }
}