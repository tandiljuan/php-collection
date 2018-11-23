<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => [
            'syntax' => 'short'
        ],
        'ordered_imports' => [
            'sortAlgorithm' => 'alpha',
        ],
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_item_single_line' => true,
        ],
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_order' => true,
    ])
    ->setFinder($finder)
    ;
