<?php

namespace CodeDetective\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Intialises the code climate yaml file.
 */
class Init extends BaseCodeClimate
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Initializes the .codeclimte.yml');

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
        $initProcess = $this->runCodeClimateProcess(
            'init',
            $input,
            $output
        );

        if (is_numeric($initProcess)) {
            return $initProcess;
        }

        $output->writeln('<info>' . $initProcess->getOutput() . '</info>');
    }
}
