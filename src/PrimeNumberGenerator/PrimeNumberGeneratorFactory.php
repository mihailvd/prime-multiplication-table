<?php

namespace Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator;

final class PrimeNumberGeneratorFactory
{
    public static function create(): PrimeNumberGeneratorInterface
    {
        return new PrimeNumberGenerator();
    }
}
