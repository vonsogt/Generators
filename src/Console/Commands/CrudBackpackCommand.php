<?php

namespace Backpack\Generators\Console\Commands;

use Artisan;
use Illuminate\Console\Command;

class CrudBackpackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backpack:crud {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD interface: Controller, Model, Request';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst($this->argument('name'));

        // Create the CRUD Controller and show output
        Artisan::call('backpack:crud-controller', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Model and show output
        Artisan::call('backpack:crud-model', ['name' => $name]);
        echo Artisan::output();

        // Create the CRUD Request and show output
        Artisan::call('backpack:crud-request', ['name' => $name]);
        echo Artisan::output();

        $name = str_replace($this->laravel->getNamespace(), '', $name);
        $controller = $this->laravel['path'].'/'.str_replace('\\', '/', $name).'CrudController';

        // Create the CRUD route
        Artisan::call('php artisan backpack:add-custom-route', [
            'code' => "Route::crud('".$name."', '".$controller."');"
        ]);
        echo Artisan::output();

        // Create the sidebar item
        Artisan::call('php artisan backpack:add-sidebar-content', [
            'code' => "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('".$name."') }}'><i class='nav-icon fa fa-question'></i> ".ucfirst(\Str::plural($name))."</a></li>"
        ]);
        echo Artisan::output();
    }
}
