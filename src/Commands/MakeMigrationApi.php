<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeMigrationApi extends GeneratorCommand
{
    protected $name = 'make:migration-api';
    protected $description = 'Create a new database migration with field definitions';
    protected $type = 'Migration';

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        
        $table = $this->option('table') ?: $this->getTableFromName($name);
        $className = $this->getClassName($name);
        
        $fieldsDefinition = $this->generateFieldsDefinition('');
        
        return str_replace(
            ['{{ class }}', '{{ table }}', '{{ fields }}'],
            [$className, $table, $fieldsDefinition],
            $stub
        );
    }

    protected function getStub()
    {
        return __DIR__ . '/../Stubs/migration.api.stub';
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $timestamp = date('Y_m_d_His');
        $filename = $timestamp . '_' . Str::snake(trim(strtolower($this->argument('name')))) . '.php';
        
        return database_path('migrations/' . $filename);
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return '';
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the migration']
        ];
    }

    protected function getOptions()
    {
        return [
            ['table', 't', InputOption::VALUE_OPTIONAL, 'The table name'],
        ];
    }

    protected function getTableFromName($name)
    {
        // Extract table name from migration name
        $name = strtolower($name);
        
        if (Str::startsWith($name, 'create_') && Str::endsWith($name, '_table')) {
            return Str::between($name, 'create_', '_table');
        }
        
        if (Str::startsWith($name, 'add_') && Str::contains($name, '_to_')) {
            return Str::afterLast($name, '_to_');
        }
        
        return Str::plural(Str::snake($name));
    }

    protected function getClassName($name)
    {
        return Str::studly($name);
    }

    protected function generateFieldsDefinition($fields)
    {
        if (empty($fields)) {
            return "            \$table->id();\n            \$table->timestamps();";
        }

        $fieldDefinitions = [];
        $fieldDefinitions[] = "            \$table->id();";
        
        $fieldsArray = array_map('trim', explode(',', $fields));
        
        foreach ($fieldsArray as $field) {
            $fieldDef = $this->parseField($field);
            if ($fieldDef) {
                $fieldDefinitions[] = "            " . $fieldDef;
            }
        }
        
        $fieldDefinitions[] = "            \$table->timestamps();";
        
        return implode("\n", $fieldDefinitions);
    }

    protected function parseField($field)
    {
        // Field format examples:
        // name:string
        // email:string:unique
        // age:integer:nullable
        // price:decimal:10,2
        // is_active:boolean:default:true
        
        $parts = explode(':', $field);
        $fieldName = trim($parts[0]);
        $fieldType = isset($parts[1]) ? trim($parts[1]) : 'string';
        $modifiers = array_slice($parts, 2);
        
        if (empty($fieldName)) {
            return null;
        }

        $definition = "\$table->{$fieldType}('{$fieldName}'";
        
        // Handle special field types with parameters
        if (in_array($fieldType, ['decimal', 'float', 'double'])) {
            $precision = 8;
            $scale = 2;
            
            foreach ($modifiers as $modifier) {
                if (strpos($modifier, ',') !== false) {
                    [$precision, $scale] = explode(',', $modifier, 2);
                    break;
                }
            }
            
            $definition = "\$table->{$fieldType}('{$fieldName}', {$precision}, {$scale}";
        } elseif (in_array($fieldType, ['string', 'char'])) {
            $length = 255;
            
            foreach ($modifiers as $modifier) {
                if (is_numeric($modifier)) {
                    $length = $modifier;
                    break;
                }
            }
            
            if ($fieldType === 'string' && $length !== 255) {
                $definition = "\$table->{$fieldType}('{$fieldName}', {$length}";
            }
        }
        
        $definition .= ')';
        
        // Add modifiers
        foreach ($modifiers as $modifier) {
            $modifier = trim($modifier);
            
            if ($modifier === 'nullable') {
                $definition .= '->nullable()';
            } elseif ($modifier === 'unique') {
                $definition .= '->unique()';
            } elseif ($modifier === 'index') {
                $definition .= '->index()';
            } elseif (Str::startsWith($modifier, 'default')) {
                if (strpos($modifier, ':') !== false) {
                    $defaultValue = Str::after($modifier, ':');
                    if (in_array($defaultValue, ['true', 'false'])) {
                        $definition .= "->default({$defaultValue})";
                    } elseif (is_numeric($defaultValue)) {
                        $definition .= "->default({$defaultValue})";
                    } else {
                        $definition .= "->default('{$defaultValue}')";
                    }
                } else {
                    $definition .= '->default(null)';
                }
            }
        }
        
        $definition .= ';';
        
        return $definition;
    }

    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);

        if (! $this->files->exists(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        if ($this->files->exists($path)) {
            $this->error('Migration already exists!');
            return false;
        }

        $this->files->put($path, $this->buildClass($name));
        
        $this->info('Migration created successfully: ' . basename($path));
        
        return true;
    }
}
