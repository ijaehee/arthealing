<?php 
namespace Artgrafii\Pinfo\Facades\Laravel ; 

use Illuminate\Support\Facades\Facade ; 

class Pinfo extends Facade { 
    protected static function getFacadeAccessor()
    {
        return 'pinfo' ; 
    }
}
