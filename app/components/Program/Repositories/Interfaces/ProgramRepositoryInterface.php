<?php
namespace Program\Repositories\Interfaces ; 

interface ProgramRepositoryInterface { 

    public function find($id) ; 
    public function register($data) ; 
    public function update($data) ; 

}
