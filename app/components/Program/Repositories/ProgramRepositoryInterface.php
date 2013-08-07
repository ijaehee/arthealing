<?php
namespace Program\Repositories ; 

interface ProgramRepositoryInterface 
{ 
    public function setListCount($listCount) ; 
    public function find($id) ; 
    public function all() ; 
    public function getPagination() ; 
    public function by() ; 
    public function getItems($page) ; 
    public function create($data) ; 
    public function update($data) ; 
    public function delete($id) ; 
}
