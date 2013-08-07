<?php 
namespace Program ; 

use Program\Repositories\ProgramRepositoryInterface;

class ProgramProcessor {
    protected $programRepository;

    public function __construct(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    public static function validate($formData=null){
        $rules = array(
            'name' => 'Required',
            'category' => 'Required',
            'exhibition_id' => 'Required'
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
            return null;
        }

        $this->programRepository->create($formData);
    }

    public function modify($formData)
    {
        if(!$this->validate($formData) || $formData == null){
            return null;
        }
        $this->programRepository->update($formData);
    }

    public function getItems($page=1)
    {
        return $this->programRepository->getItems($page);
    }

    public function getPagination()
    {
        return $this->programRepository->getPagination();
    }

    public function delete($id)
    {
        return $this->programRepository->delete($id);
    }
}
