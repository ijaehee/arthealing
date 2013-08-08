<?php
namespace Member\Repositories ; 

interface MemberRepositoryInterface 
{ 
    public function setListCount($listCount) ; 
    public function find($id) ; 
    public function all() ; 
    public function getPagination($searchData) ; 
    public function by() ; 
    public function getItems($page,$searchData) ; 
    public function create($data) ; 
    public function update($data) ; 
    public function delete($id) ; 
}
