<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

final class ExpressionParserFactory
{
    public static function create(): ExpressionParserInterface
    {
        return new ExpressionParser();
    }
}
