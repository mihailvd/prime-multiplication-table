<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

use InvalidArgumentException;

class ExpressionParser implements ExpressionParserInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function parse(string $expression, int|float $operand1, int|float $operand2): int|float
    {
        $expressionWithFilledVars = str_replace(['x', 'y'], [$operand1, $operand2], $expression);

        $operations = [
            ['*', fn($x, $y) => $x * $y],
            ['/', fn($x, $y) => $x / $y],
            ['+', fn($x, $y) => $x + $y],
            ['-', fn($x, $y) => $x - $y],
        ];

        $result = $this->calculate($expressionWithFilledVars, $operations);

        return round($result, 2);
    }

    /**
     * @throws InvalidArgumentException
     */
    private function calculate(string $expression, array $operations): int|float
    {
        [$operation, $operationHandler] = array_pop($operations);

        $tokens = explode($operation, $expression);

        $result = null;
        for ($i = 0; $i < count($tokens); $i++) {
            $currentToken = $tokens[$i];
            if (!is_numeric($currentToken) && !empty($operations)) {
                $currentToken = $this->calculate($currentToken, $operations);
            }

            if (!is_numeric($currentToken)) {
                throw new InvalidArgumentException('Unsupported math expression!');
            }

            $result = $i === 0 ? $currentToken : $operationHandler($result, $currentToken);
        }

        return $result;
    }
}
