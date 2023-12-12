<?php

namespace Mihailvd\PrimeMultiplicationTable\Output;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;

interface MatrixOutputInterface
{
    public const OUTPUT_MODE_STDOUT = 'stdout';
    public const OUTPUT_MODE_HTML = 'html';

    public function output(MatrixDto $matrixDto): void;
}
