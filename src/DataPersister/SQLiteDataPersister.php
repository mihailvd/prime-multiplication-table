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
        $tableName = 'matrix' . count($xAxis) . 'x' . count($yAxis);
        $this->prepareTable($tableName);
        $this->insertRecords($tableName, $xAxis, $yAxis, $matrix);
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
    private function insertRecords(string $tableName, array $xAxis, array $yAxis, array $matrix): void
    {
        $sql = 'INSERT INTO ' . $tableName . ' (prime1, prime2, function_return)
            VALUES (:prime1, :prime2, :functionReturn)';
        $statement = $this->pdo->prepare($sql);

        foreach ($xAxis as $xIndex => $xPrimeNumber) {
            foreach ($yAxis as $yIndex => $yPrimeNumber) {
                $statement->execute([
                    ':prime1' => $xPrimeNumber,
                    ':prime2' => $yPrimeNumber,
                    ':functionReturn' => $matrix[$xIndex][$yIndex]
                ]);
            }
        }
    }
}
