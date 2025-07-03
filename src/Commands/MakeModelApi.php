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
        $fillable = $this->option('fillable') ?: '';
        $casts = $this->option('casts') ?: '';
        
        // Process fillable fields
        $fillableArray = '';
        if ($fillable) {
            $fields = array_map('trim', explode(',', $fillable));
            $fillableArray = "'" . implode("',\n        '", $fields) . "'";
        }

        // Process casts
        $castsArray = '';
        if ($casts) {
            $castPairs = array_map('trim', explode(',', $casts));
            $castsFormatted = [];
            foreach ($castPairs as $pair) {
                if (strpos($pair, ':') !== false) {
                    [$field, $cast] = explode(':', $pair, 2);
                    $castsFormatted[] = "'" . trim($field) . "' => '" . trim($cast) . "'";
                }
            }
            $castsArray = implode(",\n        ", $castsFormatted);
        }

        return str_replace(
            ['{{ Model }}', '{{ table }}', '{{ fillable }}', '{{ casts }}'],
            [$model, $table, $fillableArray, $castsArray],
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
            ['fillable', 'f', InputOption::VALUE_OPTIONAL, 'Comma-separated list of fillable fields'],
            ['casts', 'c', InputOption::VALUE_OPTIONAL, 'Comma-separated list of field:cast pairs'],
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
        $fillable = $this->option('fillable') ?: '';
        
        $this->call('make:migration-api', [
            'name' => 'create_' . $table . '_table',
            '--table' => $table,
            '--fields' => $fillable,
        ]);
    }
}
