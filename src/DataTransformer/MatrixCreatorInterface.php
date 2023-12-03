<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

interface MatrixCreatorInterface
{
    public function generate(array $xAxis, array $yAxis, OperationInterface $operation): array;
}
