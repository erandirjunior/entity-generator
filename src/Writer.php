<?php

namespace EntityGenerator;

class Writer
{
    private $content;

    private $namespace;

    private $tableName;

    private $path;

    private $className;

    public function __construct(QuestionEntity $questionEntity, string $path)
    {
        $this->content      = $questionEntity->getContent();
        $this->namespace    = $questionEntity->getNamespace();
        $this->tableName    = $questionEntity->getTableName();
        $this->className    = $questionEntity->getClassName();
        $this->path         = $path;
    }


    public function writeFile()
    {
        $content = $this->replaceContent();

        $newFile = $this->path.$this->className.'.php';
        $file = fopen($newFile, "wb");
        fwrite($file, $content);
        fclose($file);
    }

    private function replaceContent()
    {
        $root = dirname(__DIR__).'/src/';

        $contentSkeleton = file_get_contents($root.'entity.txt');
        $content = str_replace('@Namespace@', $this->namespace, $contentSkeleton);
        $content = str_replace('@CONTENT@', $this->content, $content);
        $content = str_replace('@TABLE_NAME@', $this->tableName, $content);
        $content = str_replace('@CLASS_NAME@', $this->className, $content);
        $content = str_replace('        ', '    ', $content);

        return $content;
    }
}