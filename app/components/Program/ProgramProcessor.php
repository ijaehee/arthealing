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

    public function addFile($formData)
    {
        $additionalFileData = array() ;
        $additionalFileData['user_id'] = 1 ; 
        $drive = \Drive::getDrive('Artwork') ;

        if(isset($formData['main_image'])){
            $main_file = $drive->createFile($formData['main_image'],$additionalFileData) ;

            $formData['main_image'] = $main_file->id;
            $formData['main_src'] = $main_file->full_path;
        }

        if(isset($formData['$sub_image'])){
            $sub_file = $drive->createFile($formData['$sub_image'],$additionalFileData) ;
            $formData['sub_image'] = $sub_file->id;
            $formData['sub_src'] = $sub_file->full_path;
        }
        
        return $formData; 
    }

    public function create($formData)
    {
        if(!$this->validate($formData) || $formData == null){
            throw new \Exception('not validate or data is null');
        }

        $formData = $this->addFile($formData);

        $this->programRepository->create($formData);
    }

    public function modify($formData)
    {
        if($formData == null){
            throw new \Exception('not validate or data is null');
        }

        $formData = $this->addFile($formData);

        $this->programRepository->update($formData);
    }

    public function getItems($page=1)
    {
        return $this->programRepository->getItems($page);
    }

    public function getItem($id)
    {
        return $this->programRepository->find($id);
    }

    public function getAll()
    {
        return $this->programRepository->all();
    }

    public function getActivatedItems()
    {
        return $this->programRepository->getActivatedItems();
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
