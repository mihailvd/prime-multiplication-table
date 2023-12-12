<?php

namespace Mihailvd\PrimeMultiplicationTable\Output;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;

class HtmlMatrixOutput implements MatrixOutputInterface
{
    public function __construct(
        private readonly string $outputFilename
    ) {
    }

    public function output(MatrixDto $matrixDto): void
    {
        $outputFile = fopen($this->outputFilename, 'w');

        $output = '<table>';

        $output .= '<tr><th></th>';
        foreach ($matrixDto->getXAxis() as $xAxisValue) {
            $output .= '<th>' . $xAxisValue . '</th>';
        }
        $output .= '</tr>';

        foreach ($matrixDto->getYAxis() as $yIndex => $yAxisValue) {
            $output .= '<tr>';
            $output .= '<th>' . $yAxisValue . '</th>';

            foreach ($matrixDto->getXAxis() as $xIndex => $xAxisValue) {
                $output .= '<td>' . $matrixDto->getMatrix()[$xIndex][$yIndex] . '</td>';
            }

            $output .= '</tr>';
        }

        $output .= '</table>';

        fwrite($outputFile, $output);
        fclose($outputFile);
    }
}
