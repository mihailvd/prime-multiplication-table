<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

interface ExpressionParserInterface
{
    public function parse(string $expression, int $operand1, int $operand2): float;
}
