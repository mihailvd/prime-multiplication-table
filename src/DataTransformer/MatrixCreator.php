<?php

namespace Mihailvd\PrimeMultiplicationTable\DataTransformer;

use InvalidArgumentException;

class MatrixCreator implements MatrixCreatorInterface
{
    /**
     * @param int|float[] $xAxis
     * @param int|float[] $yAxis
     * @return int|float[][]
     * @throws InvalidArgumentException
     */
    public function generate(array $xAxis, array $yAxis, OperationInterface $operation): array
    {
        $matrix = [];

        foreach ($yAxis as $y) {
            $row = [];
            foreach ($xAxis as $x) {
                $row[] = $operation->perform($x, $y);
            }
            $matrix[] = $row;
        }

        return $matrix;
    }
}
