<?php

class MemberController extends BaseController {

    public function signupForm()
    {
        return View::make('member/signup') ; 
    }

    public function signup()
    {
        $param = Input::json() ;
        $data = array() ;

        $data['email'] = $param->get('email') ;
        $data['password'] = $param->get('password') ;
        $data['username'] = $param->get('username') ;

        $response = array() ;

        try {
            $users = Sentry::register($data) ;
            $response['msg'] = '가입완료.이제부터 새글의 팬이 되어보세요.';
            return Response::json($response,201) ;
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $response['msg'] = '[Email] 정보를 올바르게 입력하세요.';
            return Response::json($response,406) ;
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $response['msg'] = '[Password]를 올바르게 입력하세요.';
            return Response::json($response,406) ;
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $response['msg'] = '이미 회원 가입을 했습니다. ';
            return Response::json($response,409) ;
        }
    }
}
