<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

interface ExpressionParserInterface
{
    public function parse(string $expression, int|float $operand1, int|float $operand2): int|float;
}
