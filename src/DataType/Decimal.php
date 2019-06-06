<?php

namespace EntityGenerator\Type;

class Decimal extends DataType implements Type
{
    private $dataType;

    private $scale;

    private $precision;

    public function next(Type $type)
    {
        $this->dataType = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'decimal') {
            $this->setAnnotationTypeParameter('string');
            $this->setPrecision($field['precision']);
            $this->setSacale($field['scale']);

            return $this->create($field);
        }

        return $this->dataType->handle($field);
    }

    private function setSacale($scale)
    {
        $this->scale = "scale={$scale}, ";
    }

    private function setPrecision($precision)
    {
        $this->precision = "precision={$precision}";
    }

    protected function createAttribute()
    {
        return '
        
        /**
         * @var '.implode('|', $this->annotationTypeParameter).'
         *
         * @ORM\Column('.$this->columnName.', '.$this->columnType.', '.$this->precision.', '.$this->scale.', '.$this->columnLength.$this->nullable.')
         */
         private $'.$this->attibuteName.';';
    }
}