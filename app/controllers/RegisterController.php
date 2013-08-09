<?php
use Register\RegisterProcessor; 
use Program\ProgramProcessor; 

class RegisterController extends \BaseController {

    protected $registerProcessor ; 
    protected $programProcessor ; 

    public function __construct(RegisterProcessor $registerProcessor,ProgramProcessor $programProcessor)
    { 
        $this->registerProcessor  = $registerProcessor ; 
        $this->programProcessor  = $programProcessor ; 
    }

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
    public function createForm()
    {
        $programs = $this->programProcessor->getActivatedItems();

        return View::make('register/register')->with('programs',$programs)->with('action','register') ; 
    }

    public function create()
    {
        $formData = $this->getFormData();
        unset($formData['id']);

        try{
            $this->registerProcessor->create($formData);
        } catch (Exception $e) {
            $response = array();
            $response['error'] = 2;
            $response['msg'] = '값을 제대로 입력하여 주시길 바랍니다.';

            $programs = $this->programProcessor->getAll();
            return View::make('register/register',$response)->with('programs',$programs)->with('action','register') ; 
        }

        return Redirect::to('register/list');
    }

    public function modify()
    {
        $formData = $this->getFormData();
        try{
            $this->registerProcessor->modify($formData);
        } catch (Exception $e) {
            return Redirect::to('register/form/'.$formData['id']);
        }
        
        return Redirect::to('register/form/'.$formData['id']);
    }

    private function getFormData()
    {
        $formData = array();
        $formData['id'] = Input::get('id');
        $formData['program_id'] = Input::get('program_id');
        $formData['due_date'] = Input::get('due_date');
        $formData['deadline_date'] = Input::get('deadline_date');
        $formData['limit_people'] = Input::get('limit_people');
        $formData['etc'] = Input::get('etc');

        return $formData; 
    }

    public function modifyForm($id=null){
        $register = $this->registerProcessor->getItem($id);

        $programs = $this->programProcessor->getAll();
        return View::make('register/register')->with('register',$register)->with('programs',$programs)->with('action','register') ;
    }

    public function activated($id=null){
        $formData = array();
        $formData['id'] = $id;
        $formData['activated'] = 1;

        try{
            $this->registerProcessor->modify($formData);
        } catch (Exception $e) {

        }

        return Redirect::to('register/list');
    }

    public function inactivated($id=null){
        $formData = array();
        $formData['id'] = $id;
        $formData['activated'] = 0;

        try{
            $this->registerProcessor->modify($formData);
        } catch (Exception $e) {

        }

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
        $this->registerProcessor->delete($id);

        return Redirect::to('register/list');
    }

    public function registerList($page=1, $searchKey=null, $searchValue=null)
    {
        $registers = $this->registerProcessor->getItems($page); 
        $pagination = $this->registerProcessor->getPagination(); 
        $pagination['page'] = $page;

        $result = array();
        $result['registers'] = $registers ; 
        $result['pagination'] = $pagination ; 

        return View::make('register/list',$result)->with('action','register') ; 
    }
}
