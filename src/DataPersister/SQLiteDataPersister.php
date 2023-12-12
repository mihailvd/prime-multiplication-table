<?php

namespace Mihailvd\PrimeMultiplicationTable\DataPersister;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;
use PDO;

class SQLiteDataPersister implements DataPersisterInterface
{
    public function __construct(
        private readonly PDO $pdo
    ) {
    }

    /**
     * @param MatrixDto $matrixDto
     */
    public function persistMatrix(MatrixDto $matrixDto): void
    {
        $tableName = 'matrix' . count($matrixDto->getXAxis()) . 'x' . count($matrixDto->getYAxis());
        $this->prepareTable($tableName);
        $this->insertRecords($tableName, $matrixDto);
    }

    private function prepareTable(string $tableName): void
    {
        $queries = [
            'DROP TABLE IF EXISTS ' . $tableName,
            'CREATE TABLE ' . $tableName . ' (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                prime1 REAL,
                prime2 REAL,
                function_return REAL
            )'
        ];

        foreach ($queries as $query) {
            $this->pdo->exec($query);
        }
    }

    /**
     * @param int|float[] $xAxis
     * @param int|float[] $yAxis
     * @param int|float[][] $matrix
     */
    private function insertRecords(string $tableName, MatrixDto $matrixDto): void
    {
        $sql = 'INSERT INTO ' . $tableName . ' (prime1, prime2, function_return)
            VALUES (:prime1, :prime2, :functionReturn)';
        $statement = $this->pdo->prepare($sql);

        foreach ($matrixDto->getXAxis() as $xIndex => $xPrimeNumber) {
            foreach ($matrixDto->getYAxis() as $yIndex => $yPrimeNumber) {
                $statement->execute([
                    ':prime1' => $xPrimeNumber,
                    ':prime2' => $yPrimeNumber,
                    ':functionReturn' => $matrixDto->getMatrix()[$xIndex][$yIndex]
                ]);
            }
        }
    }
}
