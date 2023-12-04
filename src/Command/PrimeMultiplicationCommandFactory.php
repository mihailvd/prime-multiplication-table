<?php

namespace Mihailvd\PrimeMultiplicationTable\Command;

use Mihailvd\PrimeMultiplicationTable\DataPersister\SQLiteDataPersisterFactory;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreatorFactory;
use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGeneratorFactory;

final class PrimeMultiplicationCommandFactory
{
    public static function create(string $sqliteFilename): PrimeMultiplicationCommand
    {
        return new PrimeMultiplicationCommand(
            primeNumberGenerator: PrimeNumberGeneratorFactory::create(),
            matrixCreator: MatrixCreatorFactory::create(),
            dataPersister: SQLiteDataPersisterFactory::create($sqliteFilename)
        );
    }
}
