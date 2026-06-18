<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CrudGenerator extends Command
{
    /**
     * Mapping of stub name => output path (with CrudGenerator placeholder).
     *
     * @var array<string, string>
     */
    protected array $stubs = [
        'controller' => 'app/Http/Controllers/CrudGeneratorController.php',
        'repository' => 'app/Repositories/CrudGeneratorRepository.php',
        'service' => 'app/Services/CrudGeneratorService.php',
        'store-request' => 'app/Http/Requests/StoreRequest/StoreCrudGeneratorRequest.php',
        'update-request' => 'app/Http/Requests/UpdateRequest/UpdateCrudGeneratorRequest.php',
        'resource' => 'app/Http/Resources/CrudGeneratorResource.php',
        'model' => 'app/Models/CrudGenerator.php',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:crud  {name} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating CRUD App With Rest API';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $path = $this->option('path') ?? ucfirst($name);

        foreach ($this->stubs as $stubName => $outputPath) {
            $stubFile = base_path('stubs/crud/'.$stubName.'.stub');
            $targetFile = base_path(str_replace('CrudGenerator', $name, $outputPath));

            $this->info('[ ETA ]: '.str_replace('CrudGenerator', $name, $outputPath));

            $content = file_get_contents($stubFile);
            $content = str_replace(
                ['CrudGenerator', 'crudgenerators', 'crudgenerator', 'CrudgeneratorId'],
                [$name, $path, strtolower($name), strtolower($name).'_id'],
                $content
            );

            $dir = dirname($targetFile);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($targetFile, $content);
        }

        Artisan::call('make:migration create_'.strtolower($name).'s_table');

        $this->info('[ ETA ]: Created Successfully!');
    }
}
