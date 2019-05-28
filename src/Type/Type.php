<?php

namespace EntityGenerator\Type;


interface Type
{
    public function next(Type $type);

    public function handle(array $field);
}