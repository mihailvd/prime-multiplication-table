<?php

namespace Mihailvd\PrimeMultiplicationTable\DataPersister;

interface DataPersisterInterface
{
    public function persistMatrix(array $xAxis, array $yAxis, array $matrix): void;
}
