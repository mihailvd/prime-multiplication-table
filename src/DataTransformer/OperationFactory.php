<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

final class OperationFactory
{
    public static function create(string $expression): OperationInterface
    {
        return new Operation(
            expressionParser: ExpressionParserFactory::create(),
            expression: $expression
        );
    }
}
