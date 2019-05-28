<?php

namespace EntityGenerator\Type;

abstract class Field
{
    public function createAttribute($field, $type)
    {
        $nullable = $field === 'n' ? 'false' : 'true';

        $attributeName = $this->convertUnderscoreToCamelCase($field['name']);

        $attribute = '
        /**
         * @ORM\Column(name="'.$field['name'].'", type="'.$field['type'].'", nullable='.$nullable.')
         */
         private $'.$attributeName.';
         ';

        $methods = '
        
        /**
         * Set '.$attributeName.'.
         *
         * @param string|null $observacao
         *
         * @return '.$type.'
         */
        public function set'.ucfirst($attributeName).'('.$attributeName.' = null)
        {
            $this->'.$attributeName.' = '.$attributeName.';
    
            return $this;
        }
    
        /**
         * Get '.$attributeName.'.
         *
         * @return string|null
         */
        public function get'.ucfirst($attributeName).'()
        {
            return $this->'.$attributeName.';
        }';

        $mounted = [
            'attribute' => $attribute,
            'methods' => $methods
        ];

        return $mounted;
    }

    private function convertUnderscoreToCamelCase($attribute)
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

        return $pieces ? implode('', $pieces) : $attribute;
    }
}