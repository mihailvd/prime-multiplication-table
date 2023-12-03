<?php

namespace Mihailvd\PrimeMultiplicationTable\Command;

use InvalidArgumentException;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreatorInterface;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\OperationFactory;
use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGeneratorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PrimeMultiplicationCommand extends Command
{
    public function __construct(
        private readonly PrimeNumberGeneratorInterface $primeNumberGenerator,
        private readonly MatrixCreatorInterface $matrixCreator,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('generate')
            ->setDescription('Display an NxN primary numbers multiplication table')
            ->addArgument(
                'dimensions',
                InputArgument::OPTIONAL,
                'The size of the multiplication table to be generated',
                10
            )
            ->addOption(
                'formula',
                'f',
                InputOption::VALUE_OPTIONAL,
                'Custom calculation formula. Provide x and y, no spaces, supported operations are +,-,*,/. E.g. x*y',
                'x*y'
            );
    }

    /**
     * Execute the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int 0 if everything went fine, or an exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $dimensions = (int)$input->getArgument('dimensions');
        $mathExpression = (string)$input->getOption('formula');

        $primeNumbers = $this->primeNumberGenerator->generate($dimensions);

        try {
            $matrix = $this->matrixCreator->generate(
                xAxis: $primeNumbers,
                yAxis: $primeNumbers,
                operation: OperationFactory::create($mathExpression)
            );
        } catch (InvalidArgumentException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $this->renderTable($output, $primeNumbers, $primeNumbers, $matrix);

        return Command::SUCCESS;
    }

    /**
     * @param int|float[] $xAxis
     * @param int|float[] $yAxis
     * @param int|float[][] $matrix
     */
    private function renderTable(OutputInterface $output, array $xAxis, array $yAxis, array $matrix): void
    {
        $table = new Table($output);
        $table->setHeaders([' ', ...$xAxis]);

        foreach ($matrix as $index => $matrixRow) {
            $table->addRow([
                new TableCell($yAxis[$index], [
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
