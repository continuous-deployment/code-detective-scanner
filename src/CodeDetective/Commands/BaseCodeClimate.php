<?php

namespace CodeDetective\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Base class that will handle the docker process for code climate
 */
class BaseCodeClimate extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->addOption(
                'directory',
                'd',
                InputOption::VALUE_REQUIRED,
                'The directory in which to initialze on.'
            );
    }

    /**
     * Gets the process for the code climate cli.
     *
     * @param string          $command Code Climate command to run.
     * @param InputInterface  $input   InputInterface to get options from.
     * @param OutputInterface $output  OutputInterface to write to.
     *
     * @return Symfony\Component\Process\Process|integer
     */
    public function runCodeClimateProcess(
        $command,
        InputInterface $input,
        OutputInterface $output
    ) {
        $directory = $input->getOption('directory');

        $baseProcess = new Process(
            'docker run ' .
            '--rm ' .
            '--env CODE_PATH="$PWD" ' .
            '--volume "$PWD":/code ' .
            '--volume /var/run/docker.sock:/var/run/docker.sock ' .
            '--volume /tmp/cc:/tmp/cc ' .
            'codeclimate/codeclimate ' . $command,
            $directory
        );

        $baseProcess->setTimeout(null);

        try {
            $baseProcess->mustRun();
        } catch (ProcessFailedException $exeception) {
            $error = $baseProcess->getErrorOutput();
            $output->writeln('<error>' . $error . '</error>');

            return $baseProcess->getExitCode();
        }

        return $baseProcess;
    }
}
