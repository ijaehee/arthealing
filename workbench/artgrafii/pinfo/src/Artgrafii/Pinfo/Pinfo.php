<?php
namespace Artgrafii\Pinfo ; 

use Artgrafii\Pinfo\Profiles\Provider\ProviderInterface ; 
use Artgrafii\Pinfo\Profiles\Eloquent\Provider as ProfileProvider ; 

class Pinfo { 

    protected $profileProvider ; 
    protected $profile ; 

    public function __construct( 
        ProfileProviderInterface $profileProvider = null 
    )
    { 
        $this->profileProvider = $profileProvider ? : new ProfileProvider() ; 
    }

    public function save(array $profile)
    {
        $profile = $this->profileProvider->saveProfile($profile) ; 

        $this->profile = $profile ; 

        return $this->profile ; 
    }

    public function getProfileProvider()
    {
        return $this->profileProvider ; 
    }

    public function getProfileByUserId($userId)
    {
        return $this->profileProvider->getProfileByUserId($userId) ; 
    }
}
