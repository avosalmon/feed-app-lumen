<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('somedir')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers([
        'short_array_syntax', //PHP arrays should use the PHP 5.4 short-syntax.
        'ordered_use', //Ordering use statements.
        'concat_with_spaces', //Concatenation should be used with at least one whitespace around.
        'align_equals', //Align equals symbols in consecutive lines.
        'align_double_arrow', //Align double arrow symbols in consecutive lines.
        'whitespacy_lines', //Remove trailing whitespace at the end of blank lines.
        'unused_use' //Unused use statements must be removed.
    ])
    ->finder($finder)
;
