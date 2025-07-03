<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Command creates Resource
 *
 * @class MakeResourceApi
 */
class MakeResourceApi extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:resource-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for resource';

    /**
     * @var string
     */
    protected $type = 'ResourceAPI';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $model = str_replace('Resource', '', $this->argument('name'));

        return str_replace([
            '{{ Class }}'],
            [$this->argument('name'), ucfirst($model)],
            $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/resource.api.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $model = str_replace('Resource', '', $this->argument('name'));
        return "{$rootNamespace}\\Http\\Resources\\{$model}";
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the request.'],
        ];
    }
}
