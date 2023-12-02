<?php

namespace Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator;

interface PrimeNumberGeneratorInterface
{
    public function generate(int $limit): array;
}
