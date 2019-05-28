<?php

namespace EntityGenerator\Type;

class Text implements Type
{
    private $type;

    public function next(Type $type)
    {
        $this->type = $type;
    }

    public function handle(array $field)
    {
        if ($field['type'] === 'text') {
            return $this->mountAttribute($field);
        }

        return $this->type->handle($field);
    }

    private function mountAttribute($field)
    {
        return $this->createAttribute($field);
    }

    private function createAttribute($field)
    {
        $nullable = $field === 'n' ? 'false' : 'true';

        $attributeName = $this->convertUnderscoreToCamelCase($field['name']);

        $annotation = '
        /**
         * @ORM\Column(name="'.$field['name'].'", type="'.$field['type'].'", nullable='.$nullable.')
         */
         private $'.$attributeName.';
         ';

        return $annotation;
    }
    public function convertUnderscoreToCamelCase($attribute)
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