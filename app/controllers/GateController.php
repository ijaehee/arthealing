<?php

class GateController extends \BaseController {

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
		//
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
		//
	}

    public function tourList($page=1,$list_count=10)
    {
        $register = new Register ;
        $result = array();
        $search_param = array();
        $search_param['key'] = 'activated';
        $search_param['keyword'] = 1;
        $result['registers'] = $register->getList($search_param,$page,$list_count);
        return View::make('gate/list')->with('result',$result) ;
    }

    public function applyForm($register_id=null)
    {
        if($register_id == null){
            return Redirect::to('/gate/list');
        }

        $tour = new Tour;
        $tour->hit_count($register_id);

        $register = register::find($register_id);
        $program = Program::find($register->program_id) ;
        return View::make('gate/apply')->with('register',$register)->with('program',$program) ;
    }

    public function apply()
    {
        try
        {
            if( !Sentry::check()){
                return Redirect::to('/login');
            }
            $user = Sentry::getUser();

            $data = array();
            $data['register_id'] = Input::get('register_id');
            $data['user_id'] = $user->id;
            $data['email'] = $user->email;
            $data['username'] = $user->first_name;

            $tour = new Tour;
            $tour->create($data);

            return Redirect::to('/gate/list');
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        { 
            $response['msg'] = '로그인하세요.';
            return Redirect::to('/login',$response);
        }catch (Exception $e){
            return Redirect::to('/gate/apply/'.Input::get('register_id'));
        }
    }
}
