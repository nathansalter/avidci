<?php

namespace Examples;

use AvidCi\Pipelines\PipelineInterface;
use AvidCi\Pipelines\PipelineSecrets;
use AvidCi\Pipelines\RunningPipe;
use AvidCi\Pipelines\RunStatus;
use AvidCi\Plugins\ShellPlugin;

class SimpleLibraryPipeline implements PipelineInterface
{
    public function __construct(
        private ShellPlugin $shellPlugin
    ) {}

    public function run(RunningPipe $pipe, PipelineSecrets $secrets): RunStatus
    {
        $this->shellPlugin->run($pipe, 'composer',
            arguments: ['install', '--no-dev', '--optimize-autoloader'],
            label: 'Composer Install'
        );
        $this->shellPlugin->run($pipe, 'bin/phpunit', label: 'PHPUnit');
        return new RunStatus(true);
    }
}
