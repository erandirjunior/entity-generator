<?php

namespace EntityGenerator;

use EntityGenerator\Type\Date;
use EntityGenerator\Type\Datetime;
use EntityGenerator\Type\Id;
use EntityGenerator\Type\Integer;
use EntityGenerator\Type\Decimal;
use EntityGenerator\Type\Text;
use EntityGenerator\Type\Varchar;
use Symfony\Component\Console\Question\Question;

class QuestionEntity
{
    private $fields = [];

    private $content = [];

    private $namespace = '';

    private $tableName = '';

    private $helper = '';

    private $input = '';

    private $output = '';

    public function __construct()
    {
        $this->fields       = [];
        $this->namespace    = '';
        $this->tableName    = '';
        $this->content      = [
            'attributes' => '',
            'methods'    => '',
        ];
    }

    public function getClassName()
    {
        $namespaceArray = explode('\\', $this->namespace);

        return array_pop($namespaceArray);
    }

    public function getContent()
    {
        return implode('', $this->content);
    }

    protected function setContentAttribute($attibute)
    {
        $this->content['attributes'] .= $attibute;
    }

    protected function setContentMethods($methods)
    {
        $this->content['methods'] .= $methods;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    private function setTableName()
    {
        $tableNameQuestion  = 'What is the name of table? (e.g. tb_contract) ';
        $question           = new Question($tableNameQuestion, null);

        do {
            $this->tableName  = $this->helper->ask($this->input, $this->output, $question);
        } while (!$this->tableName);
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    private function setNamespace()
    {
        $namespaceQuestion  = 'What is the namespace class? ';
        $question           = new Question($namespaceQuestion, null);

        do {
            $this->namespace = $this->helper->ask($this->input, $this->output, $question);
        } while (!$this->namespace);
    }

    public function questions($input, $output, $helper)
    {
        $this->input    = $input;
        $this->output   = $output;
        $this->helper   = $helper;

        $this->setTableName();
        $this->askQuestion();
        $this->setNamespace();

        $className = $this->getClassName();

        $id         = new Id($className);
        $varchar    = new Varchar($className);
        $integer    = new Integer($className);
        $datetime   = new Datetime($className);
        $date       = new Date($className);
        $text       = new Text($className);
        $decimal    = new Decimal($className);
        $contentId  = $id->createId();

        $this->setContentAttribute($contentId['attribute']);
        $this->setContentMethods($contentId['methods']);

        $varchar->next($integer);
        $integer->next($datetime);
        $datetime->next($date);
        $date->next($text);
        $text->next($decimal);

        foreach ($this->fields as $field) {
            $contentField = $varchar->handle($field, $this->getClassName());

            $this->setContentAttribute($contentField['attribute']);
            $this->setContentMethods($contentField['methods']);
        }
    }

    private function askQuestion()
    {
        $otherFieldQuestion = 'Do you wish add other field? [y|n] ';
        $number             = 1;
        $typeFieldQuestions = [
            'varchar' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'length' => [
                    'question' => 'What is field length? [255] ',
                    'default' => 255,
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'text' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'integer' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'boolean' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => true,
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'datetime' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'date' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'decimal' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
                ],
                'precision' => [
                    'question' => 'What is field precision? ',
                    'default' => 10,
                ],
                'scale' => [
                    'question' => 'What is it field scale? ',
                    'default' => 0,
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
        ];
        $typeFieldQuestion  = "What is the field type? ";
        $typeFieldQuestion .= " [varchar, text, integer, decimal, boolean, datetime, date] ";

        do {
            $question   = new Question($typeFieldQuestion, null);
            $type       = $this->helper->ask($this->input, $this->output, $question);
            $type       = strtolower($type);

            if (!empty($typeFieldQuestions[$type])) {
                $this->askQuestionFromDataType($typeFieldQuestions[$type], $type, $number);
            }

            $question = new Question($otherFieldQuestion, null);
            $continue = $this->helper->ask($this->input, $this->output, $question);

            $number++;

        } while ($continue === 'Y' || $continue === 'y');
    }

    private function askQuestionFromDataType($questions, $type, $number)
    {
        foreach ($questions as $key => $question) {
            $object = new Question($question['question'], $question['default']);

            $this->fields[$number][$key] = $this
                                            ->helper
                                            ->ask($this->input, $this->output, $object);
            $this->fields[$number]['type'] = $type;
        }
    }
}