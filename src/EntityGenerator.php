<?php

namespace EntityGenerator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class EntityGenerator extends Command
{
    protected function configure()
    {
        $this->setName('generate:entity')
            ->setDescription('Create a new Controller, Service, Repository and Routes.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionEntity = new QuestionEntity();

        $questionEntity->questions($input, $output, $this->helper($output));
    }

    public function helper($output)
    {
        $outputStyle = new OutputFormatterStyle('red', 'default', array('bold', 'blink'));
        $output->getFormatter()->setStyle('error', $outputStyle);
        return $this->getHelper('question');
    }
}