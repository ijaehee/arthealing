<?php
namespace Artgrafii\Pinfo\Profiles ; 

interface ProfileInterface {

    public function getProfileImage() ; 
    public function validate() ; 
    public function save() ; 
}
