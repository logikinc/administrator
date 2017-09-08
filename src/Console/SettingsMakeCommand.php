<?php

namespace Terranet\Administrator\Console;

use Illuminate\Console\GeneratorCommand;

class SettingsMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'administrator:resource:settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new administrator settings resource [Requires terranet/options package.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/module.settings.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.config('administrator.paths.module');
    }

    protected function getArguments()
    {
        return [];
    }

    protected function getNameInput()
    {
        return 'Settings';
    }
}
