<?php
namespace Member\Repositories ; 

use Member\Repositories\MemberRepositoryInterface ; 
use Member\Member ; 

class MemberRepository implements MemberRepositoryInterface {
    protected $model ; 
    protected $listCount=20 ; 

    public function __construct()
    {
        $this->model = new Member ; 
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

    public function getPagination($searchData=null)
    {
        $pagination = array();

        if(isset($searchData['selected_group']) && $searchData['selected_group'] != ""){
            $pagination['totalCount'] =$this->model->select('users.*')->join('users_groups','users.id','=','users_groups.user_id')->where('users_groups.group_id',$searchData['selected_group'])->count();
        }else if(isset($searchData['selected_email']) && $searchData['selected_email'] != ""){
            $pagination['totalCount'] =$this->model->where('email','like','%'.$searchData['selected_email'].'%')->count();
        }else{
            $pagination['totalCount'] =  $this->model->all()->count();
        }

        $pagination['listCount'] =  $this->listCount;
        $pagination['pageCount'] =  ceil($pagination['totalCount']/$pagination['listCount']);

        return $pagination;
    }

    public function by() 
    {
    }

    public function getItems($page=1,$searchData=null)
    {   
        $listCount = $this->listCount ; 
        if(isset($searchData['selected_group']) && $searchData['selected_group'] != ""){
            $result =$this->model->select('users.*')->join('users_groups','users.id','=','users_groups.user_id')->where('users_groups.group_id',$searchData['selected_group'])->skip(($page-1)*$listCount)->take($listCount)->get();
        }else if(isset($searchData['selected_email'])  && $searchData['selected_email'] != ""){
            $result =$this->model->where('email','like','%'.$searchData['selected_email'].'%')->skip(($page-1)*$listCount)->take($listCount)->get();
        }else{
            $result = $this->model->skip(($page-1)*$listCount)->take($listCount)->get();
        }
        return $result;
    }

    public function create($data)
    { 
        return $this->model->fill($data)->save() ; 
    }

    public function update($data)
    {
        $member = $this->find($data['id']) ; 
        return $member->fill($data)->update(); 
    }

    public function delete($id)
    {
        return $this->find($id)->delete(); 
    }
}
