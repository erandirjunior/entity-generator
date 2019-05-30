<?php

namespace EntityGenerator\Type;

abstract class DataType
{
    protected $nullable;

    protected $nullableParameter;

    protected $name;

    protected $options;

    protected $type;

    protected $length;

    protected $attibuteName;

    protected function setNullable($nullable)
    {
        $this->nullable             = 'nullable=false';
        $this->nullableParameter    = '';

        if ($nullable === 'y') {
            $this->nullable = 'nullable=true';
            $this->nullableParameter = ' = null';
        }
    }

    protected function setName($name)
    {
        $this->name = "name=\"{$name}\"";
    }

    protected function setType($type)
    {
        $this->type = "type=\"{$type}\"";
    }

    protected function setLength($field)
    {
        if (!empty($field['length'])) {
            $this->length = "length={$field['length']}, ";
        }
    }

    protected function create($field, $type)
    {
        $this->convertUnderscoreToCamelCase($field['name']);
        $this->setNullable($field['nullable']);
        $this->setName($field['name']);
        $this->setType($field['type']);
        $this->setLength($field);

        $attribute  = $this->createAttribute();
        $methods    = $this->createMethods($type);

        return [
            'attribute' => $attribute,
            'methods'   => $methods,
        ];
    }

    protected function createMethods($type)
    {
        return '
        
        /**
         * Set '.$this->attibuteName.'.
         *
         * @return '.$type.'
         */
        public function set'.ucfirst($this->attibuteName).'('.$this->attibuteName.$this->nullableParameter.')
        {
            $this->'.$this->attibuteName.' = '.$this->attibuteName.';
    
            return $this;
        }
    
        /**
         * Get '.$this->attibuteName.'.
         *
         * @return string
         */
        public function get'.ucfirst($this->attibuteName).'()
        {
            return $this->'.$this->attibuteName.';
        }';
    }

    protected function createAttribute()
    {
        return '
        
        /**
         * @var 
         *
         * @ORM\Column('.$this->name.', '.$this->type.', '.$this->length.$this->nullable.')
         */
         private $'.$this->attibuteName.';';
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