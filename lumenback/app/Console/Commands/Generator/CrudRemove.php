<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;

class CrudRemove extends Command
{
    /**
     * The CRUD Files of the console command.
     */
    protected array $fileNames = [
        'app/Events/CrudGeneratorEvent',
        'app/Http/Controllers/CrudGeneratorController',
        'app/Http/Requests/StoreRequest/StoreCrudGeneratorRequest',
        'app/Http/Requests/UpdateRequest/UpdateCrudGeneratorRequest',
        'app/Http/Resources/CrudGeneratorResource',
        'app/Jobs/CrudGeneratorJob',
        'app/Listeners/CrudGeneratorListener',
        'app/Models/CrudGenerator',
        'app/Policies/CrudGeneratorPolicy',
        'app/Observers/CrudGeneratorObserver',
        'app/Repositories/CrudGeneratorRepository',
        'app/Services/CrudGeneratorService',
        'database/factories/CrudGeneratorFactory',
        'database/seeders/CrudGeneratorSeeder',
        'tests/Feature/CrudGeneratorTest',
        'tests/Unit/CrudGeneratorTest',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:remove {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removing CRUD App With REST API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pathX = $this->argument('name');
        $filamentResourceDir = app_path("Filament/Resources/{$pathX}s");

        if (is_dir($filamentResourceDir)) {
            $this->deleteDirectory($filamentResourceDir);
            $this->info("[ ETA ]: Removed Filament Resource directory {$filamentResourceDir}");
        }

        foreach (glob(database_path('migrations/*_create_'.strtolower($pathX).'s_table.php')) as $migrationFile) {
            @unlink($migrationFile);
            $this->info('[ ETA ]: Removed Migration '.basename($migrationFile));
        }

        foreach ($this->fileNames as $fileName) {
            echo '[ ETA ]: '.str_replace('CrudGeneratpr', $this->argument('name'), $fileName).'.php'.PHP_EOL;
            @unlink(str_replace('CrudGenerator', $this->argument('name'), $fileName).'.php');
        }
        $this->info("[ ETA ]: CRUD for {$pathX} removed successfully!");
    }
    //

    private function deleteDirectory($dir)
    {
        if (! file_exists($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            $path = "$dir/$file";

            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                @unlink($path);
            }
        }
        rmdir($dir);
    }
}
