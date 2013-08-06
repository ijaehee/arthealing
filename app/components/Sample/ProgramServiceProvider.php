<?php
namespace Program; 

use Illuminate\Support\ServiceProvider ; 
use Program\Repositories\Interfaces\ProgramRepositoryInterface ;
use Program\Repositories\ProgramRepository ; 

class ProgramServiceProvider extends ServiceProvider {
     
    public function register()
    {
        $this->app->bind('Program\Repositories\Interfaces\ProgramRepositoryInterface','Program\Repositories\ProgramRepository') ; 
    }
} 
