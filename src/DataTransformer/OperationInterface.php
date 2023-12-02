<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

interface OperationInterface
{
    public function perform(int $operand1, int $operand2): float;
}
