<?php

namespace EntityGenerator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EntityGenerator extends Command
{
    protected $dataBaseType;

    public function __construct(string $dataBaseType)
    {
        $this->dataBaseType = $dataBaseType;
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('generate:entity')
            ->setDescription('Create a new entity.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionEntity = new QuestionEntity($this->dataBaseType);

        $questionEntity->questions($input, $output, $this->helper($output));

        $writer = new Writer($questionEntity, $questionEntity->getPath());

        $writer->writeFile();
    }

    public function helper($output)
    {
        $outputStyle = new OutputFormatterStyle('red', 'default', array('bold', 'blink'));
        $output->getFormatter()->setStyle('error', $outputStyle);
        return $this->getHelper('question');
    }
}