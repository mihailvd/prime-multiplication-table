<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

use InvalidArgumentException;

readonly class Operation implements OperationInterface
{
    public function __construct(
        private ExpressionParserInterface $expressionParser,
        private string $expression
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function perform(int $operand1, int $operand2): float
    {
        return $this->expressionParser->parse($this->expression, $operand1, $operand2);
    }
}
