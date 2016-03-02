<?php

namespace CodeDetective\Commands;

use CodeDetective\AnalysisFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Analyses the code base using the code climate yaml file.
 */
class Analyze extends BaseCodeClimate
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('analyze')
            ->setDescription('Analyzes your source code')
            ->addOption(
                'detective_host',
                'dhost',
                InputOption::VALUE_OPTIONAL,
                'The IP/hostname of the detective instance to send the json to.'
            );

        parent::configure();
    }

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $detectiveHost = $input->getOption('detective_host');

        $outputProcess = $this->runCodeClimateProcess(
            'analyze -f json',
            $input,
            $output
        );

        if (is_numeric($outputProcess)) {
            return $outputProcess;
        }

        $jsonAnalysis = $outputProcess->getOutput();

        $formatter = new AnalysisFormatter();
        $formatter->setIssues(json_decode($jsonAnalysis));
        $textAnalysis = $formatter->getTextOutput();

        $output->writeln($textAnalysis);
    }
}
