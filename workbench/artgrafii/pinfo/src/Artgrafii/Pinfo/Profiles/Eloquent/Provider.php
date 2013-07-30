<?php
namespace Artgrafii\Pinfo\Profiles\Eloquent ; 

use Artgrafii\Pinfo\Profiles\ProviderInterface ; 

class Provider implements ProviderInterface {
    
    protected $model = 'Artgrafii\Pinfo\Profiles\Eloquent\Profile' ; 

    public function getProfileById($id)
    {
        $model = $this->createModel() ;

        if( ! $profile = $model->newQuery()->find($id)) { 
            return null ; 
        } 
        return $profile ; 

    }

    public function getProfileByEmail($email)
    {
        $model = $this->createModel() ;
        $result = $model->newQuery()->where('email','=',$username)->get() ; 

        if( ! $profile = $result->first()){ 
            return null ;
        }

        return $profile ;
    }

    public function getProfileByUserId($user_id)
    {
        $model = $this->createModel() ;
        $result = $model->newQuery()->where('user_id','=',$user_id)->get() ; 

        if( ! $profile = $result->first()){ 
            return null ;
        }

        return $profile ;
    }

    public function getProfileByUsername($username)
    {
        $model = $this->createModel() ;
        $result = $model->newQuery()->where('username','=',$username)->get() ; 

        if( ! $profile = $result->first()){ 
            return null ;
        }

        return $profile ; 
    }

    public function saveProfile(array $profile)
    {
        $model = $this->createModel() ; 
        $model->fill($profile) ; 
        $model->save() ; 

        return $model ;
    }

    public function create(array $profile)
    {
        $model = $this->createModel() ; 
        $model->fill($profile) ; 
        $model->save() ; 

        return $model ; 
    } 

    public function createModel()
    {
        $class = '\\'.ltrim($this->model,'\\') ; 

        return new $class ; 
    }
}
