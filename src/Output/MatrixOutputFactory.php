<?php

namespace Mihailvd\PrimeMultiplicationTable\Output;

use InvalidArgumentException;
use Symfony\Component\Console\Output\OutputInterface;

final class MatrixOutputFactory
{
    public static function create(string $outputMode, OutputInterface $output): MatrixOutputInterface
    {
        if (MatrixOutputInterface::OUTPUT_MODE_STDOUT === $outputMode) {
            return new ConsoleMatrixOutput($output);
        } elseif (MatrixOutputInterface::OUTPUT_MODE_HTML === $outputMode) {
            return new HtmlMatrixOutput('output.html');
        } else {
            throw new InvalidArgumentException('Output method not supported');
        }
    }
}
