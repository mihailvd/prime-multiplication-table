<?php

namespace Mihailvd\PrimeMultiplicationTable\Test\DataPersister;

use Mihailvd\PrimeMultiplicationTable\DataPersister\SQLiteDataPersister;
use PDO;
use PDOStatement;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SQLiteDataPersisterTest extends TestCase
{
    public static function provideMatrices(): array
    {
        return [
            [
                [2, 3, 5, 7],
                [2, 3, 5, 7],
                [
                    [4, 5, 7, 9],
                    [5, 6, 8, 10],
                    [7, 8, 10, 12],
                    [9, 10, 12, 14]
                ]
            ],
            [
                [2, 3, 5, 7, 11],
                [2, 3, 5, 7, 11],
                [
                    [4, 6, 10, 14, 22],
                    [6, 9, 15, 21, 33],
                    [10, 15, 25, 35, 55],
                    [14, 21, 35, 49, 77],
                    [22, 33, 55, 77, 121]
                ]
            ]
        ];
    }

    #[DataProvider('provideMatrices')]
    public function testPersistMatrices(array $xAxis, array $yAxis, array $matrix): void
    {
        $pdo = $this->preparePdoMock($xAxis, $yAxis);

        $sqliteDataPersister = new SQLiteDataPersister($pdo);
        $sqliteDataPersister->persistMatrix($xAxis, $yAxis, $matrix);
    }

    private function preparePdoMock(array $xAxis, array $yAxis): PDO
    {
        $tableName = 'matrix' . count($xAxis) . 'x' . count($yAxis);

        $pdo = $this->getMockBuilder(PDO::class)
            ->setConstructorArgs(['sqlite::memory:'])
            ->onlyMethods(['exec', 'prepare'])
            ->getMock();

        $pdo->expects($this->exactly(2))
            ->method('exec')
            ->with(
                $this->logicalOr(
                    $this->equalTo('DROP TABLE IF EXISTS ' . $tableName),
                    $this->equalTo(
                        'CREATE TABLE ' . $tableName . ' (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                prime1 REAL,
                prime2 REAL,
                function_return REAL
            )'
                    )
                )
            );

        $statementMock = $this->getMockBuilder(PDOStatement::class)
            ->onlyMethods(['execute'])
            ->getMock();

        $statementMock->expects($this->exactly(count($xAxis) * count($yAxis)))
            ->method('execute');

        $pdo->expects($this->once())
            ->method('prepare')
            ->with(
                'INSERT INTO ' . $tableName . ' (prime1, prime2, function_return)
            VALUES (:prime1, :prime2, :functionReturn)'
            )
            ->willReturn($statementMock);

        return $pdo;
    }
}
