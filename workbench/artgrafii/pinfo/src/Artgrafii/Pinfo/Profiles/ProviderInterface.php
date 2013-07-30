<?php
namespace Artgrafii\Pinfo\Profiles ; 

interface ProviderInterface {
    
    public function saveProfile(array $profile) ; 
    public function getProfileById($id) ;
    public function getProfileByUsername($username) ; 
    public function getProfileByEmail($email) ; 
}
