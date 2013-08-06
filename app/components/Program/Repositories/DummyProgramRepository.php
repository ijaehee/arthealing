<?php
namespace Program\Repositories ; 

class DummyProgramRepository implements ProgramRepositoryInterface {
    protected $listCount = 20 ;  

    public function setListCount($listCount)
    {
        
    }

    public function find($id)
    { 
        $obj = new stdClass ; 
        $obj->id = $id ; 
        $obj->title = 'hello' ; 

        return $obj ; 
    }

    public function getItems($page)
    {   
        $obj = new \stdClass ; 
        $obj->id = 1 ; 
        $obj->title = 'hello' ; 
        $obj->main_src = 'hello' ; 
        $obj->name = 'hello' ; 
        $obj->created_at = 'hello' ; 

        return array( 
            $obj,$obj,$obj
            
        ) ; 
    }

    public function create($data)
    {
    }

    public function update($data)
    {
    }

    public function save($data)
    {
    }

    public function delete($id)
    {
    }

    public function all()
    {
    }

    public function by()
    {
    }


}
