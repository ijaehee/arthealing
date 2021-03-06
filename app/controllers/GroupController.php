<?php

class GroupController extends \BaseController {

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
        $response = array() ;

        $temp = Input::get('permissions');

        $permissions = array();
        if(!empty($temp)){
            foreach($temp as $key => $value){
                $permissions[$value] = true; 
            }
        }

        try
        {
            $group = Sentry::getGroupProvider()->create(array(
                'name'        => Input::get('groupname'),
                'permissions' => $permissions
            ));
            $response['msg'] = '그룹이 생성되었습니다.';
        }
        catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
        {
            $response['msg'] = '그룹이름을 입력하세요.';
        }
        catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            $response['msg'] = '이미 그룹이 존재합니다.';
        }
        return View::make('group/create',$response)->with('action','group') ;
    }

    public function createForm()
    {
        return View::make('group/create')->with('action','group') ; 
    }

    public function modifyForm($id)
    {
        $group = array();

        try
        {
                $group = Sentry::getGroupProvider()->findById($id);
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
                echo 'Group was not found.';
        }

        return View::make('group/create')->with('group',$group)->with('action','group') ; 
    }

    public function modify()
    {
        $response = array() ;
        $group = array();
        try
        {
            $id = Input::get('id') ;
            $group = Sentry::getGroupProvider()->findById($id);

            if(Input::get('groupname')){
                $group->name = Input::get('groupname');
            }

            $temp = Input::get('permissions');
            $permissions = array();
            if(!empty($temp)){
                foreach($temp as $key => $value){
                    $permissions[$value] = true; 
                }
                $group->permissions = $permissions;
            }

            if ($group->save())
            {
                $group = Sentry::getGroupProvider()->findById($id);
                $response['msg'] = '그룹이 수정되었습니다.';
            }
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            $response['msg'] = '그룹이 존재하지 않습니다.';
        }
        
        return View::make('group/create',$response)->with('group',$group)->with('action','group') ;
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
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $group->delete();
        }
        catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
        }
        return Redirect::to('group/list')->with('action','group');  
    }

    public function groupList()
    {
        $result = array();

        try {
            $result['groups'] = Sentry::getGroupProvider()->findAll();
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {

        }
        return View::make('group/list')->with('result',$result)->with('action','group') ;
    }
}
