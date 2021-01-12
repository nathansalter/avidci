<?php

namespace App\Tests\examples;

use AvidCi\Pipelines\PipelineSecrets;
use AvidCi\Pipelines\RunningPipe;
use AvidCi\Pipelines\RunStatus;
use AvidCi\Plugins\ShellPlugin;
use Examples\SimpleLibraryPipeline;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SimpleLibraryPipelineTest extends TestCase
{
    private RunningPipe $pipe;
    private ShellPlugin|MockObject $shellPlugin;
    private SimpleLibraryPipeline $pipeline;

    protected function setUp(): void
    {
        $this->shellPlugin = $this->createMock(ShellPlugin::class);
        $this->pipe = $this->createMock(RunningPipe::class);
        $this->pipeline = new SimpleLibraryPipeline($this->shellPlugin);
    }

    public function testRunsPipe()
    {
        $this->shellPlugin->expects($this->exactly(2))
            ->method('run')
            ->withConsecutive(
                [$this->pipe, 'composer'],
                [$this->pipe, 'bin/phpunit']
            )->willReturn([]);
        $status = $this->pipeline->run($this->pipe, new PipelineSecrets([]));
        $this->assertEquals(new RunStatus(true), $status);
    }
}
