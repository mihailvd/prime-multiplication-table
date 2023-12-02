<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

final class MatrixCreatorFactory
{
    public static function create(): MatrixCreatorInterface
    {
        return new MatrixCreator();
    }
}
