<?php

namespace Mihailvd\PrimeMultiplicationTable\Dto;

class MatrixDto
{
    public function __construct(
        private array $xAxis,
        private array $yAxis,
        private array $matrix
    ) {
    }

    public function getXAxis(): array
    {
        return $this->xAxis;
    }

    public function getYAxis(): array
    {
        return $this->yAxis;
    }

    public function getMatrix(): array
    {
        return $this->matrix;
    }
}
