<?php

class ProgramController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $response = array();

        $data = array();
        $data['name'] = Input::get('programname');
        $data['category'] = Input::get('category');
        $data['exhibition_id'] = Input::get('exhibition');
        $data['place'] = Input::get('place');
        $data['content'] = Input::get('content');
        $main_image = Input::file('main_image') ;
        $sub_image = Input::file('sub_image') ;

        $additionalFileData = array() ;
        $additionalFileData['user_id'] = 1 ; 
        $drive = Drive::getDrive('Artwork') ;

        if(isset($main_image)){
            $main_file = $drive->save($main_image,$additionalFileData) ;

            $data['main_image'] = $main_file->id;
            $data['main_src'] = $main_file->full_path;
        }

        if(isset($main_image)){
            $sub_file = $drive->save($sub_image,$additionalFileData) ;
            $data['sub_image'] = $sub_file->id;
            $data['sub_src'] = $sub_file->full_path;
        }

        try { 
            $program = new Program ;
            $program->create($data) ; 
            $response['success'] = 1;
            $response['msg'] = '프로그램이 생성 되었습니다.';
        } catch(Exception $e) { 
            $response['success'] = 2;
            $response['msg'] = '프로그램이 생성 되지 않았습니다.';
        }

        return View::make('program/create',$response) ;
    }

    public function createForm()
    {
        return View::make('program/create') ; 
    }

    public function programList($page=0,$list_count=10)
    {
        $program = new Program ;
        $result = array();
        $result['programs'] = $program->all() ;
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
        $program = Program::find($id) ;
        $program->delete() ; 

        return Redirect::to('program/list');
    }
}
