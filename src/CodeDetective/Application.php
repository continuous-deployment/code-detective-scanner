<?php

namespace CodeDetective;

use CodeDetective\Commands\Analyze;
use CodeDetective\Commands\Init;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * Main entry point to the code detective CLI.
 */
class Application extends ConsoleApplication
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct('CodeDetective', '0.0.1');

        $this->add(new Init());
        $this->add(new Analyze());
    }
}
