<?php
use Program\Repositories\ProgramRepositoryInterface; 

class ProgramController extends \BaseController {
    
    protected $programRepository ; 

    public function __construct(ProgramRepositoryInterface $programRepository)
    { 
        $this->programRepository = $programRepository ; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    { 
    }

    public function modify()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function register()
    {
        $response = array();

        $data = array();
        $data['name'] = Input::get('programname');
        $data['category'] = Input::get('category');
        $data['exhibition_id'] = Input::get('exhibition');
        $data['place'] = Input::get('place');
        $data['id'] = Input::get('id');
        $data['content'] = Input::get('content');
        $main_image = Input::file('main_image') ;
        $sub_image = Input::file('sub_image') ;

        $additionalFileData = array() ;
        $additionalFileData['user_id'] = 1 ; 
        $drive = Drive::getDrive('Artwork') ;

        if(isset($main_image)){
            $main_file = $drive->createFile($main_image,$additionalFileData) ;

            $data['main_image'] = $main_file->id;
            $data['main_src'] = $main_file->full_path;
        }

        if(isset($sub_image)){
            $sub_file = $drive->createFile($sub_image,$additionalFileData) ;
            $data['sub_image'] = $sub_file->id;
            $data['sub_src'] = $sub_file->full_path;
        } 
        
        $response = array() ; 

        try {
            $this->programRepository->save($data) ; 
            $response['msg'] = '저장되었습니다.' ; 
        } catch (Exception $e) {

        }

        return View::make('program/register',$response) ; 
    }

    public function createForm()
    {
        return View::make('program/register') ; 
    }

    public function modifyForm($id=null){
        $response = array();

        $program = array();
        $program = program::find($id);
        return View::make('program/register',$response)->with('program',$program) ;
    }

    public function programList($page=1, $searchKey=null, $searchValue=null)
    {
        $listCount = 1; 
        $programs = $this->programRepository->getItems($page) ; 
        $result = array();
        $result['programs'] = $programs ; 

        return View::make('program/list')->with('result',$result) ; 
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
        $this->programRepository->delete($id) ; 

        return Redirect::to('program/list');
    }
}
