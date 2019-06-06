<?php

namespace EntityGenerator\DataType;


interface Type
{
    public function next(Type $type);

    public function handle(array $field);
}