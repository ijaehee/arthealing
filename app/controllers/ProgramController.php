<?php
use Program\ProgramProcessor; 

class ProgramController extends \BaseController {
    
    protected $programProcessor ; 

    public function __construct(ProgramProcessor $programProcessor)
    { 
        $this->programProcessor  = $programProcessor ; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { 
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $formData = $this->setFormData();
        unset($formData['id']);

        try{
            $this->programProcessor->create($formData);
        } catch (Exception $e) {
            $response = array();
            $response['success'] = 2;
            return View::make('program/register',$response) ; 
        }

        return Redirect::to('program/list');
    }

    public function modify()
    {
        $formData = $this->setFormData();
        try{
            $this->programProcessor->modify($formData);
        } catch (Exception $e) {
            return Redirect::to('program/form/'.$formData['id']);
        }
        
        return Redirect::to('program/form/'.$formData['id']);
    }

    public function setFormData()
    {
        $formData = array();
        $formData['id'] = Input::get('id');
        $formData['name'] = Input::get('programname');
        $formData['category'] = Input::get('category');
        $formData['exhibition_id'] = Input::get('exhibition');
        $formData['place'] = Input::get('place');
        $formData['content'] = Input::get('content');
        $formData['main_image'] = Input::file('main_image') ;
        $formData['sub_image'] = Input::file('sub_image') ;

        $formData = $this->addFile($formData);

        return $formData; 
    }

    public function addFile($formData)
    {
        $additionalFileData = array() ;
        $additionalFileData['user_id'] = 1 ; 
        $drive = Drive::getDrive('Artwork') ;

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

    public function createForm()
    {
        return View::make('program/register')->with('action','program') ; 
    }

    public function programList($page=1, $searchKey=null, $searchValue=null)
    {
        $programs = $this->programProcessor->getItems($page); 
        $pagination = $this->programProcessor->getPagination(); 
        $pagination['page'] = $page;

        $result = array();
        $result['programs'] = $programs ; 
        $result['pagination'] = $pagination ; 

        return View::make('program/list',$result)->with('action','program') ; 
    }


    public function modifyForm($id=null){
        $response = array();

        $program = array();
        $program = program::find($id);
        return View::make('program/register',$response)->with('program',$program)->with('action','program') ;
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->programProcessor->delete($id);

        return Redirect::to('program/list');
    }
}
