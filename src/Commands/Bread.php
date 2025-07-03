<?php

namespace UzInfo\LaravelApiGenerator\Commands;

use Illuminate\Console\Command;

class Bread extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bread {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate complete BREAD (Browse, Read, Edit, Add, Delete) components for a model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = $this->argument('model');
        
        $this->info('🚀 Creating BREAD components for model: ' . $model);
        $this->newLine();
        
        // Create Model and Migration
        $this->comment('📊 Creating Model...');
        $this->call('make:model-api', [
            'name' => $model,
            '--migration' => true
        ]);
        
        // Create other components
        $list_actions = [
            'Repository' => [
                'command'  => 'make:repository-api',
                'argument' => $model.'Repository',
                'emoji' => '🗄️'
            ],
            'Service' => [
                'command'  => 'make:service-api',
                'argument' => $model.'Service',
                'emoji' => '⚙️'
            ],
            'Controller' => [
                'command'  => 'make:controller-api',
                'argument' => $model.'Controller',
                'emoji' => '🎮'
            ],
            'Resource' => [
                'command'  => 'make:resource-api',
                'argument' => $model.'Resource',
                'emoji' => '📦'
            ],
            'ResourceList' => [
                'command'  => 'make:resource-list-api',
                'argument' => $model.'ResourceList',
                'emoji' => '📦'
            ],
            'Store Request' => [
                'command'  => 'make:request-api',
                'argument' => 'Store'.$model.'Request',
                'emoji' => '📝'
            ],
            'Update Request' => [
                'command'  => 'make:request-api',
                'argument' => 'Update'.$model.'Request',
                'emoji' => '✏️'
            ],
        ];

        foreach ($list_actions as $action_name => $action) {
            $this->comment($action['emoji'] . ' Creating ' . $action_name . '...');
            $this->call($action['command'], ['name' => $action['argument']]);
        }

        $this->newLine();
        $this->info('✅ BREAD generation completed successfully!');
        $this->newLine();
        
        // Show summary
        $this->showSummary($model);

        return Command::SUCCESS;
    }
    
    protected function showSummary($model)
    {
        $this->line('<comment>📁 Generated Files:</comment>');
        $this->line('');
        
        $files = [
            "📊 Model: app/Models/{$model}.php",
            "📁 Migration: database/migrations/****_create_" . strtolower($model) . "s_table.php",
            "🎮 Controller: app/Http/Controllers/{$model}Controller.php",
            "⚙️ Service: app/Services/{$model}Service.php",
            "🗄️ Repository: app/Repositories/{$model}Repository.php",
            "📦 Resource: app/Http/Resources/{$model}/{$model}Resource.php",
            "📦 ResourceList: app/Http/Resources/{$model}/{$model}ResourceList.php",
            "📝 Store Request: app/Http/Requests/{$model}/Store{$model}Request.php",
            "✏️ Update Request: app/Http/Requests/{$model}/Update{$model}Request.php",
        ];
        
        foreach ($files as $file) {
            $this->line("  {$file}");
        }
        
        $this->newLine();
        $this->line('<comment>🎯 Next Steps:</comment>');
        $this->line('  1. Run migrations: <info>php artisan migrate</info>');
        $this->line('  2. Add routes to routes/api.php');
        $this->line('  3. Update model relationships if needed');
        $this->line('  4. Customize validation rules in request classes');
        $this->newLine();
    }
}
