<?php

class RegisterController extends \BaseController {

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
        $data['program_id'] = Input::get('program_id');
        $data['due_date'] = Input::get('due_date');
        $data['people'] = Input::get('people');
        $data['etc'] = Input::get('etc');

        $register = new Register;
        if(Input::get('id')){
            try { 
                $pre_register = $register->find(Input::get('id')); 
                $pre_register->update($data);
                $response['success'] = 1;
                $response['msg'] = '힐링이 수정되었습니다.';
            } catch(Exception $e) { 
                $response['success'] = 2;
                $response['msg'] = '힐링이 수정되지 않았습니다.';
            }
        }else{
            try { 
                $register->create($data) ; 
                $response['success'] = 1;
                $response['msg'] = '힐링이 생성 되었습니다.';
            } catch(Exception $e) { 
                $response['success'] = 2;
                $response['msg'] = '힐링이 생성 되지 않았습니다.';
            }
        }

        $program = new Program ;
        $programs = array();
        $programs = $program->all() ;
        return View::make('register/register',$response)->with('programs',$programs) ;
    }

    public function createForm()
    {
        $program = new Program ;
        $programs = array();
        $programs = $program->all() ;
        return View::make('register/register')->with('programs',$programs) ; 
    }

    public function modifyForm($id=null){
        $response = array();

        $register = array();
        $register = register::find($id);

        $program = new Program ;
        $programs = array();
        $programs = $program->all() ;
        return View::make('register/register',$response)->with('program',$program) ;
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
        $register = Register::find($id) ;
        $register->delete() ; 

        return Redirect::to('register/list');
    }

    public function registerList($page=0,$list_count=10)
    {
        $register = new Register ;
        $result = array();
        $result['registers'] = $register->all() ;
        return View::make('register/list')->with('result',$result) ; 
    }
}
