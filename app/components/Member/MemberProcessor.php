<?php 
namespace Member ; 

use Member\Repositories\MemberRepositoryInterface;

class MemberProcessor {
    protected $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public static function validate($formData=null){
        $rules = array(
            'email' => 'Required',
            'name' => 'Required',
            'password' => 'Required'
        );

        $validator = \Validator::make($formData, $rules);

        if($validator->passes())
        {
            return true;
        }

        return false;
    }

    public function create($formData)
    {
        if(!$this->validate($formData) || $formData == null){
            throw new \Exception('not validate or data is null');
        }

        $this->memberRepository->create($formData);
    }

    public function modify($formData)
    {
        if($formData == null){
            throw new \Exception('not validate or data is null');
        }
        $this->memberRepository->update($formData);
    }

    public function getItems($page=1,$searchData)
    {
        return $this->memberRepository->getItems($page,$searchData);
    }

    public function getItem($id)
    {
        return $this->memberRepository->find($id);
    }

    public function getPagination()
    {
        return $this->memberRepository->getPagination();
    }

    public function delete($id)
    {
        return $this->memberRepository->delete($id);
    }
}
