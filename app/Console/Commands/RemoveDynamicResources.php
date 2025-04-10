<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveDynamicResources extends Command
{
    protected $signature = 'remove:dynamic {name} {--m : Remove model} {--c : Remove controller} {--r : Remove request} {--s : Remove service} {--v : Remove view} {--se : Remove seeder} {--f : Remove factory}';
    protected $description = 'Remove dynamic resources: model, controller, request, service, view, seeder, factory';

    public function handle()
    {
        $name = $this->argument('name');

        // Create Model
        $this->deleteFile(app_path("Models/{$name}.php"));
        $this->deleteMigration($name);
        $this->info("Model '$name' deleted successfully.");
        // Create Controller
        $this->deleteFile(app_path("Http/Controllers/Backend/{$name}Controller.php"));
        $this->info("Controller '{$name}Controller' deleted successfully.");
        // Create Request
        $this->deleteFile(app_path("Http/Requests/{$name}Request.php"));
        $this->info("Request '{$name}Request' deleted successfully.");
        // Create View
        $this->deleteDirectory(resource_path("js/Pages/Backend/{$name}"));
        $this->info("View '{$name}' deleted successfully.");
        // Create Service
        $serviceModel = $name;
        $this->deleteFile(app_path("Services/{$name}Service.php"));
        $this->info("Service '$serviceModel' deleted successfully.");
        // Create Seeder
        $this->deleteFile(database_path("seeders/{$name}Seeder.php"));
        $this->info("Seeder '{$name}Seeder' deleted successfully.");
        // Create Factory
        $this->deleteFile(database_path("factories/{$name}Factory.php"));
        $this->info("Factory '{$name}Factory' deleted successfully.");

        // Create Model
        // if ($this->option('m')) {
        //     $this->deleteFile('make:model', ['name' => $name, '--migration' => true]);
        //     $this->info("Model '$name' deleted successfully.");
        // }

        // Create Controller
        // if ($this->option('c')) {
        //     $this->deleteFile('make:controller', ['name' => $name . 'Controller', '--resource' => true]);
        //     $this->info("Controller '{$name}Controller' deleted successfully.");
        // }

        // Create Request
        // if ($this->option('r')) {
        //     $this->deleteFile('make:request', ['name' => $name . 'Request']);
        //     $this->info("Request 'Store{$name}Request' deleted successfully.");
        // }

        // Create Service
        // if ($this->option('s')) {
        //     $serviceName = $name . 'Service';
        //     $this->createService($serviceName);
        //     $this->info("Service '$serviceName' deleted successfully.");
        // }

        // Create View
        // if ($this->option('v')) {
        //     $this->createView($name);
        //     $this->info("View '{$name}' deleted successfully.");
        // }

        // Create Seeder
        // if ($this->option('se')) {
        //     $this->deleteFile('make:seeder', ['name' => $name . 'Seeder']);
        //     $this->info("Seeder '{$name}Seeder' deleted successfully.");
        // }

        // Create Factory
        // if ($this->option('f')) {
        //     $this->deleteFile('make:factory', ['name' => $name . 'Factory']);
        //     $this->info("Factory '{$name}Factory' deleted successfully.");
        // }
    }

    protected function deleteFile($path)
    {
        if (File::exists($path)) {
            File::delete($path);
            $this->info("File '{$path}' deleted successfully.");
        } else {
            $this->warn("File '{$path}' does not exist.");
        }
    }

    protected function deleteDirectory($path)
    {
        if (File::exists($path)) {
            File::deleteDirectory($path);
            $this->info("Directory '{$path}' deleted successfully.");
        } else {
            $this->warn("Directory '{$path}' does not exist.");
        }
    }

    // Delete migration related to the model
    protected function deleteMigration($modelName)
    {
        // Search for migration files containing the model name
        $files = File::files(database_path('migrations'));
        foreach ($files as $file) {
            if (strpos($file->getFilename(), strtolower($modelName)) !== false) {
                File::delete($file->getPathname());
                $this->info("Migration '{$file->getFilename()}' related to '{$modelName}' deleted successfully.");
            }
        }
    }
}
