<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Command create Repository
 *
 * @class MakeSeriveApi
 */
class MakeControllerApi extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:controller-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for Controller API';

    /**
     * @var string
     */
    protected $type = 'ControllerAPI';

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
        $model = str_replace('Controller', '', $this->argument('name'));
        $service = $model.'Service';
        $tag = ucfirst($model.'s');
        $route = strtolower($model.'s');
        $request = $model.'Request';
        $resource = $model.'Resource';
        $list_resource = $model.'ResourceList';


        return str_replace([
            '{{ Class }}', '{{ Service }}', '{{ Model }}', '{{ Route }}', '{{ Tag }}', '{{ Request }}', '{{ Resource }}', '{{ ListResource }}'],
            [$this->argument('name'), ucfirst($service), $model, $route, $tag, $request, $resource, $list_resource],
            $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../Stubs/controller.api.request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
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
