<?php

namespace Mihailvd\PrimeMultiplicationTable\DataPersister;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;

interface DataPersisterInterface
{
    public function persistMatrix(MatrixDto $matrixDto): void;
}
