<?php
namespace Program\Repositories ; 
use Program\Repositories\ProgramRepositoryInterface ; 
use Program\Program ; 

class ProgramRepository implements ProgramRepositoryInterface {
    protected $model ; 
    protected $listCount=20 ; 

    public function __construct()
    {
        $this->model = new Program ; 
    }

    public function setListCount($listCount)
    {
        $this->listCount = $listCount ; 
    }

    public function find($id)
    {
        return $this->model->find($id) ; 
    }

    public function all()
    {
        return $this->model->all() ; 
    }

    public function by() 
    {
    }

    public function getItems($page=1)
    {   
        $listCount = $this->listCount ; 
        return $this->model->skip(($page-1)*$listCount)->take($listCount)->get() ; 
    }

    public function create($data)
    { 
        unset($data['id']) ; 
        return $this->model->fill($data)->save() ; 
    }

    public function update($data)
    {
        $program = $this->find($data['id']) ; 
        return $program->fill($data)->update(); 
    }

    public function save($data)
    {
        if(isset($data['id']) && $data['id'] > 0 ){ //update 
            return $this->update($data) ; 
        }else{ //create 
            return $this->create($data) ; 
        }
    }

    public function delete($id)
    {
        return $this->find($id)->delete(); 
    }
}
