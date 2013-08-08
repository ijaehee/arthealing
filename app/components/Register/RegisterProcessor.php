<?php 
namespace Register ; 

use Register\Repositories\RegisterRepositoryInterface;

class RegisterProcessor {
    protected $registerRepository;

    public function __construct(RegisterRepositoryInterface $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public static function validate($formData=null){
        $rules = array(
            'program_id' => 'Required',
            'due_date' => 'Required',
            'limit_people' => 'Required|Numeric'
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

        $this->registerRepository->create($formData);
    }

    public function modify($formData)
    {
        if($formData == null){
            throw new \Exception('not validate or data is null');
        }
        $this->registerRepository->update($formData);
    }

    public function getItems($page=1)
    {
        return $this->registerRepository->getItems($page);
    }

    public function getItem($id)
    {
        return $this->registerRepository->find($id);
    }

    public function getPagination()
    {
        return $this->registerRepository->getPagination();
    }

    public function delete($id)
    {
        return $this->registerRepository->delete($id);
    }
}
