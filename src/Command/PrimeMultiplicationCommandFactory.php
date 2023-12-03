<?php

namespace Mihailvd\PrimeMultiplicationTable\Command;

use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreatorFactory;
use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGeneratorFactory;

final class PrimeMultiplicationCommandFactory
{
    public static function create(): PrimeMultiplicationCommand
    {
        return new PrimeMultiplicationCommand(
            primeNumberGenerator: PrimeNumberGeneratorFactory::create(),
            matrixCreator: MatrixCreatorFactory::create()
        );
    }
}
