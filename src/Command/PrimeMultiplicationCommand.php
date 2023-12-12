<?php

namespace Mihailvd\PrimeMultiplicationTable\Command;

use InvalidArgumentException;
use Mihailvd\PrimeMultiplicationTable\DataPersister\DataPersisterInterface;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\MatrixCreatorInterface;
use Mihailvd\PrimeMultiplicationTable\DataTransformer\OperationFactory;
use Mihailvd\PrimeMultiplicationTable\Output\MatrixOutputFactory;
use Mihailvd\PrimeMultiplicationTable\PrimeNumberGenerator\PrimeNumberGeneratorInterface;
use Symfony\Component\Console\Command\Command;
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
        private readonly DataPersisterInterface $dataPersister,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('generate')
            ->setDescription('Display an NxN primary numbers multiplication table')
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Export using external output interface (stdout, html)'
            )
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
            )
            ->addOption(
                'persist',
                'p',
                InputOption::VALUE_NONE,
                'Persist the generated matrix',
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
        $persistMatrix = $input->getOption('persist');
        $outputMode = $input->getOption('output');

        $primeNumbers = $this->primeNumberGenerator->generate($dimensions);

        try {
            $matrixDto = $this->matrixCreator->generate(
                xAxis: $primeNumbers,
                yAxis: $primeNumbers,
                operation: OperationFactory::create($mathExpression)
            );
        } catch (InvalidArgumentException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $matrixOutput = MatrixOutputFactory::create($outputMode, $output);
        $matrixOutput->output($matrixDto);

        if ($persistMatrix) {
            $this->dataPersister->persistMatrix($matrixDto);
        }

        return Command::SUCCESS;
    }
}
