<?php

namespace Mihailvd\PrimeMultiplicationTable\Output;

use Mihailvd\PrimeMultiplicationTable\Dto\MatrixDto;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleMatrixOutput implements MatrixOutputInterface
{
    public function __construct(
        private readonly OutputInterface $output
    ) {
    }

    public function output(MatrixDto $matrixDto): void
    {
        $table = new Table($this->output);
        $table->setHeaders([' ', ...$matrixDto->getXAxis()]);

        foreach ($matrixDto->getMatrix() as $index => $matrixRow) {
            $table->addRow([
                new TableCell($matrixDto->getYAxis()[$index], [
                    'style' => new TableCellStyle([
                        'cellFormat' => '<info>%s</info>',
                    ])
                ]),
                ...$matrixRow
            ]);
        }

        $table->render();
    }
}
