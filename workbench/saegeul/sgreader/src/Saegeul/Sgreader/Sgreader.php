<?php
namespace Saegeul\Sgreader ; 

class Sgreader { 

    public function __construct()
    {
    }

    public function registerFeed($feed)
    {
        if(trim($feed) == '' ){
            throw InvalidFeedParameterException ; 
        } 

        $feed = new SimplePie() ; 
        $feed->set_feed_url($feed) ; 
        $success = $feed->init() ; 

    } 
}
