<?php

namespace Mihailvd\PrimeMultiplicationTable\DataPersister;

use PDO;

class SQLiteDataPersister implements DataPersisterInterface
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    /**
     * @param int|float[] $xAxis
     * @param int|float[] $yAxis
     * @param int|float[][] $matrix
     */
    public function persistMatrix(array $xAxis, array $yAxis, array $matrix): void
    {
        // TODO: Implement persistMatrix
    }
}
