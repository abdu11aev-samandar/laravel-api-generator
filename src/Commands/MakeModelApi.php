<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModelApi extends GeneratorCommand
{
    protected $name = 'make:model-api';
    protected $description = 'Create a new Eloquent model with optional migration';
    protected $type = 'Model';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $model = $this->getNameInput();
        $table = $this->option('table') ?: $this->getTableName($model);
        
        return str_replace(
            ['{{ Model }}', '{{ table }}'],
            [$model, $table],
            $stub
        );
    }

    protected function getStub()
    {
        return __DIR__ . '/../Stubs/model.api.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model']
        ];
    }

    protected function getOptions()
    {
        return [
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model'],
            ['table', 't', InputOption::VALUE_OPTIONAL, 'The table name for the model'],
        ];
    }

    protected function getTableName($model)
    {
        return strtolower(str_replace('\\', '', $model)) . 's';
    }

    public function handle()
    {
        $result = parent::handle();

        if ($this->option('migration')) {
            $this->createMigration();
        }

        return $result;
    }

    protected function createMigration()
    {
        $model = $this->getNameInput();
        $table = $this->option('table') ?: $this->getTableName($model);
        
        $this->call('make:migration-api', [
            'name' => 'create_' . $table . '_table',
            '--table' => $table,
        ]);
    }
}
