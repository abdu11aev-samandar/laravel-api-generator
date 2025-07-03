<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeResourceListApi extends GeneratorCommand
{
    protected $name = 'make:resource-list-api';
    protected $description = 'Command for resource list';
    protected $type = 'ResourceListAPI';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $model = str_replace('ResourceList', '', $this->argument('name'));
        $resource = $model . 'Resource';

        return str_replace(
            ['{{ Class }}', '{{ Resource }}'],
            [$this->argument('name'), ucfirst($resource)],
            $stub
        );
    }

    protected function getStub()
    {
        return __DIR__ . '/../Stubs/resource-list.api.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $model = str_replace('ResourceList', '', $this->argument('name'));
        return "$rootNamespace\\Http\\Resources\\$model";
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the request.']
        ];
    }
}
