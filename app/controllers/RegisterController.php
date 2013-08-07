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
    public function register()
    {
        $data = array();
        $data['program_id'] = Input::get('program_id');
        $data['due_date'] = Input::get('due_date');
        $data['limit_people'] = Input::get('limit_people');
        $data['etc'] = Input::get('etc');

        $register = new Register;
        if(Input::get('id')){
            try { 
                $pre_register = $register->find(Input::get('id')); 
                $pre_register->update($data);
            } catch(Exception $e) { 

            }
            return Redirect::to('register/modify/'.Input::get('id'));
        }else{
            try { 
                $register->create($data) ; 

                return Redirect::to('register/list');
            } catch(Exception $e) { 
                $response = array();
                $response['success'] = 2;
                $response['msg'] = '힐링이 생성 되지 않았습니다.';

                $program = new Program ;
                $programs = array();
                $programs = $program->all() ;

                return View::make('register/register',$response)->with('programs',$programs) ;
            }
        }
    }

    public function createForm()
    {
        $program = new Program ;
        $programs = array();
        $programs = $program->all() ;
        return View::make('register/register')->with('programs',$programs)->with('action','register') ; 
    }

    public function modifyForm($id=null){
        $register = array();
        $register = register::find($id);

        $program = new Program ;
        $programs = array();
        $programs = $program->all() ;
        return View::make('register/register')->with('register',$register)->with('programs',$programs)->with('action','register') ;
    }

    public function activated($id=null){
        $register = Register::find($id) ;
        $data = array();
        $data['activated'] = 1;
        $register->update($data);

        return Redirect::to('register/list');
    }

    public function inactivated($id=null){
        $register = Register::find($id) ;
        $data = array();
        $data['activated'] = 0;
        $register->update($data);

        return Redirect::to('register/list');
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
        $search_param = array();
        $result['registers'] = $register->getList($search_param,$page,$list_count);
        return View::make('register/list')->with('result',$result)->with('action','register') ; 
    }
}
