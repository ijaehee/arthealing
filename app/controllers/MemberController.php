<?php

class MemberController extends BaseController {

    public function signupForm()
    {
        return View::make('member/signup') ; 
    }

    public function signup()
    {
        
        $data = array() ;
        $data['email'] = Input::get('email') ;
        $data['password'] = Input::get('password') ;
        $data['first_name'] = Input::get('username') ;

        $response = array() ;

        try {
            $user = Sentry::register($data) ;
            $response['msg'] = '가입완료.이제부터 아트그라피의 팬이 되어보세요.';

            $adminGroup = Sentry::getGroupProvider()->findById(2);
            $user->addGroup($adminGroup);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $response['msg'] = '[Email] 정보를 올바르게 입력하세요.';
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $response['msg'] = '[Password]를 올바르게 입력하세요.';
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $response['msg'] = '이미 회원 가입을 했습니다. ';
        }
            return View::make('member/signup',$response) ;
    }

    public function memberList($page=0,$list_count=10)
    {
        $result = array();

        $result['selected_group'] = Input::get('search_group');
        $result['selected_email'] = Input::get('search_email');
    
        try {
            if($result['selected_email']){
                $result['users'] =  Sentry::getUserProvider()->createModel()->where('email','like','%'. $result['selected_email'] .'%')->take(10)->get()  ; 
            }else if($result['selected_group']){
                $search_group = Sentry::getGroupProvider()->findById($result['selected_group']);
                $result['users'] = Sentry::getUserProvider()->findAllInGroup($search_group);
            }else{
                $result['users'] = Sentry::getUserProvider()->createModel()->take(10)->get();
            }
            
            $result['groups'] = Sentry::getGroupProvider()->findAll();
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            
        }
            return View::make('member/list')->with('result',$result) ;
    }
}
