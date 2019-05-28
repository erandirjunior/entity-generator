<?php

namespace EntityGenerator;

use EntityGenerator\Type\Datetime;
use EntityGenerator\Type\Integer;
use EntityGenerator\Type\Number;
use EntityGenerator\Type\Text;
use EntityGenerator\Type\Varchar;
use Symfony\Component\Console\Question\Question;

class QuestionEntity
{
    private $fields = [];

    public function questions($input, $output, $helper)
    {
        $tableNameQuestion  = 'What is the name of table? (e.g. tb_contract) ';
        $namespaceQuestion  = 'What is the namespace class? ';
        $question           = new Question($tableNameQuestion, null);
        $name               = $helper->ask($input, $output, $question);

        $this->askQuestion($input, $output, $helper);

        $question           = new Question($namespaceQuestion, null);
        $namespace          = $helper->ask($input, $output, $question);

        $varchar = new Varchar();
        $integer = new Integer();
        $datetime = new Datetime();
        $text = new Text();
        $number = new Number();

        $varchar->next($integer);
        $integer->next($datetime);
        $datetime->next($text);
        $text->next($number);

        foreach ($this->fields as $field) {
            //$varchar->handle($field);
            var_dump($varchar->handle($field));
        }

    }

    private function askQuestion($input, $output, $helper)
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
                'length' => [
                    'question' => 'What is field length? [11] ',
                    'default' => 11,
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
            'boolean' => [
                'name' => [
                    'question' => 'What is field name? ',
                    'default' => '',
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
                    'default' => 11,
                ],
                'scale' => [
                    'question' => 'What is it field scale? ',
                    'default' => 2,
                ],
                'nullable' => [
                    'question' => 'Is it nullable? [y|n] ',
                    'default' => 'n',
                ]
            ],
        ];
        $typeFieldQuestion  = 'What is the field type? [varchar, text, integer, number, boolean, datetime, date, decimal] ';

        do {
            $question   = new Question($typeFieldQuestion, null);
            $type       = $helper->ask($input, $output, $question);
            $type       = strtolower($type);

            if (!empty($typeFieldQuestions[$type])) {
                foreach ($typeFieldQuestions[$type] as $key => $questions) {
                    $question = new Question($questions['question'], $questions['default']);
                    $this->fields[$number][$key] = $helper->ask($input, $output, $question);
                    $this->fields[$number]['type'] = $type;
                }
            }

            $question = new Question($otherFieldQuestion, null);
            $continue = $helper->ask($input, $output, $question);

            $number++;

        } while ($continue === 'Y' || $continue === 'y');
    }
}