<?php 
namespace Artgrafii\Pinfo\Profiles\Eloquent ; 

use Illuminate\Database\Eloquent\Model ; 
use Artgrafii\Pinfo\Profiles\ProfileInterface ; 

class Profile extends Model implements ProfileInterface {

    protected $table = 'profiles' ; 
    protected $guarded = array() ; 

    public function save(array $options = array())
    {
        //$this->validate() ; 

        return parent::save($options) ; 
    }

    public function getProfileImage()
    {
    }

    public function validate()
    {
    } 
}
