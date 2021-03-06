<?php
use Member\MemberProcessor; 

class MemberController extends BaseController {

    protected $memberProcessor ; 

    public function __construct(MemberProcessor $memberProcessor)
    { 
        $this->memberProcessor  = $memberProcessor ; 
    }

    private function getSearchForm()
    {
        $searchData = array(); 

        $searchData['selected_group'] = Input::get('search_group');
        $searchData['selected_email'] = Input::get('search_email');

        return $searchData;
    }

    public function memberList($page=1)
    {
        $searchData = $this->getSearchForm();

        $users = $this->memberProcessor->getItems($page,$searchData); 
        $pagination = $this->memberProcessor->getPagination($searchData); 
        $pagination['page'] = $page;

        $result = $searchData;
        $result['users'] = $users ; 
        $result['pagination'] = $pagination ; 

        $result['groups'] = Sentry::getGroupProvider()->findAll();
         
        return View::make('member/list',$result)->with('action','member') ;
    }

    public function signupForm()
    {
        return View::make('member/signup') ; 
    }

    public function signup()
    {
        $response = array() ;

        if(!Input::get('email') || !Input::get('password') || !Input::get('password_conf')){
            $response['msg'] = '정확한 값을 입력하시길 바랍니다.';
            return View::make('member/signup',$response) ;
        }

        if(Input::get('password') != Input::get('password_conf')){
            $response['msg'] = '비밀번호와 비밀번호확인 값이 틀립니다.';
            return View::make('member/signup',$response) ;
        }

        $data = array() ;
        $data['email'] = Input::get('email') ;
        $data['password'] = Input::get('password') ;
        $data['first_name'] = Input::get('username') ;

        try {
            $user = Sentry::register($data,true) ;
            $response['msg'] = '가입완료.이제부터 아트그라피의 팬이 되어보세요.';

            $adminGroup = Sentry::getGroupProvider()->findById(2);
            $user->addGroup($adminGroup);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $response['msg'] = '[Email] 정보를 올바르게 입력하세요.';
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $response['msg'] = '[Password]를 올바르게 입력하세요.';
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $response['msg'] = '이미 회원 가입을 했습니다. ';
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){
            $response['msg'] = '그룹이 존재하지 않습니다.';
        }
        return View::make('member/signup',$response) ;
    }

    public function modifyForm($id=null)
    {
        $user = array();

        try
        {
            $user = Sentry::getUserProvider()->findById($id);
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('member/list');  
        }

        return View::make('member/view')->with('user',$user)->with('action','member') ;
    }

    public function modify()
    {

        try
        {
            $id = Input::get('id') ;

            $user = Sentry::getUserProvider()->findById($id);

            if(Input::get('password')){
                $user->password = Input::get('password');
            }

            if(Input::get('username')){
                $user->first_name = Input::get('username');
            }

            if ($user->save())
            {
                $user = Sentry::getUserProvider()->findById($id);
            }
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            $response['msg'] = '로그인한 유저가 존재합니다.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $response['msg'] = '아이디가 존재하지 않습니다.';
        }

        return View::make('member/view')->with('user',$user) ;
    }

    public function login()
    {
        $response = array();

        if(!Input::get('email') || !Input::get('password')){
            $response['msg'] = '정확한 값을 입력하시길 바랍니다.';
            return View::make('member/login',$response) ;
        }

        try
        {
            $credentials = array(
                'email'      => Input::get('email'),
                'password'   => Input::get('password'),
            );

            $user = Sentry::authenticate($credentials, false);

            return Redirect::to('/');  
        } 
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {

            $response['msg'] = '비밀번호가 틀립니다.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $response['msg'] = '아이디가 존재 하지 않습니다.';
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            $response['msg'] = '탈퇴한 사용자 입니다.';
        }

        return View::make('member/login',$response) ;
    }

    public function loginForm()
    {
        return View::make('member/login') ; 
    }

    public function leaveForm()
    {
        if( !Sentry::check()){
            return Redirect::to('member/list');  
        }
        return View::make('member/leave') ; 
    }

    public function leave()
    {
        $response = array() ;

        try
        {
            $user = Sentry::getUser();
            if( !Sentry::check()){
                return Redirect::to('/login');  
            }else if(!(Input::get('password'))){
                $response['msg'] = '비밀번호를 입력하세요.';
                return View::make('member/leave',$response) ;
            }
            
            $credentials = array(
                'email'      => $user->email,
                'password'   => Input::get('password'),
            );

            $leaveuser = Sentry::authenticate($credentials, false);
            $throttle = Sentry::getThrottleProvider()->findByUserId($leaveuser->id);
            $throttle->ban();
            //$leaveuser->delete();

            return Redirect::to('/login');  
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {

            $response['msg'] = '비밀번호가 틀립니다.';
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            $response['msg'] = '아이디가 존재 하지 않습니다.';
        }

        return View::make('member/leave',$response) ;
    }

    public function destroy($id)
    {
        try
        {
            $throttle = Sentry::getThrottleProvider()->findByUserId($id);
            $throttle->ban();
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
        }
        return Redirect::to('member/list');  
    }
}
