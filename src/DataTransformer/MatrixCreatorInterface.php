<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;

interface MatrixCreatorInterface
{
    public function generate(array $xAxis, array $yAxis, OperationInterface $operation): MatrixDto;
}
