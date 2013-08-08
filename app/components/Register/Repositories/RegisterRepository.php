<?php
namespace Register\Repositories ; 

use Register\Repositories\RegisterRepositoryInterface ; 
use Register\Register ; 

class RegisterRepository implements RegisterRepositoryInterface {
    protected $model ; 
    protected $listCount=20 ; 

    public function __construct()
    {
        $this->model = new Register ; 
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

    public function getPagination()
    {
        $pagination = array();
        $pagination['totalCount'] =  $this->model->all()->count();
        $pagination['listCount'] =  $this->listCount;
        $pagination['pageCount'] =  ceil($pagination['totalCount']/$pagination['listCount']);

        return $pagination;
    }

    public function by() 
    {
    }

    public function getItems($page=1)
    {   
        $listCount = $this->listCount ; 
        return $this->model->select('registers.*','programs.main_src','programs.name')->join('programs','registers.program_id','=','programs.id')->skip(($page-1)*$listCount)->take($listCount)->get() ; 
    }

    public function create($data)
    { 
        return $this->model->fill($data)->save() ; 
    }

    public function update($data)
    {
        $register = $this->find($data['id']) ; 
        return $register->fill($data)->update(); 
    }

    public function delete($id)
    {
        return $this->find($id)->delete(); 
    }
}
