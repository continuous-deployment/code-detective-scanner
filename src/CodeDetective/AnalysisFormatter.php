<?php

namespace CodeDetective;

use Symfony\Component\Console\Output\OutputInterface;

class AnalysisFormatter
{
    /**
     * Issues found
     *
     * @var array
     */
    protected $issues = [];

    /**
     * Set the issues to format.
     *
     * @param array $issues All the issues found within the project.
     *
     * @return void
     */
    public function setIssues(array $issues)
    {
        $this->issues = $issues;
    }

    /**
     * Gets the text output using the issues.
     *
     * @return string
     */
    public function getTextOutput()
    {
        $issues = [];

        foreach ($this->issues as $issue) {
            $path = $issue->location->path;
            if (array_key_exists($path, $issues) === false) {
                $issues[$path] = [];
            }

            $issues[$path][] = [
                'description' => $issue->description,
                'engine' => $issue->engine_name,
                'lines' => (array) $issue->location->lines
            ];
        }

        ksort($issues, SORT_STRING);

        $output = '';

        foreach ($issues as $path => $pathIssues) {
            $output .= '<fg=yellow;options=bold>' . $path . '</>' . PHP_EOL;
            foreach ($pathIssues as $issue) {
                $output .= '<fg=white>' .
                $issue['description'] .
                ' <fg=blue>Line: ' . $issue['lines']['begin'] . '-' . $issue['lines']['end'] . '</>' .
                ' [<fg=red>' . $issue['engine'] . '</>]' .
                '</>' . PHP_EOL;
            }

            $output .= PHP_EOL;
        }

        return $output;
    }
}
