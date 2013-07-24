<?php

class ReaderController extends BaseController { 
    
    public function registerFeed()
    { 
        $feed = new SimplePie() ; 
        $storage_path = storage_path(); 
        $feed->set_cache_location($storage_path.'/cache') ; 
        $feeds = array('http://artgrafii.blog.me/rss','http://happynetwork.kr/rss') ; 

        //foreach($feeds as $key => $url){ 
            $feed->set_feed_url($feeds) ; 

	        $success = $feed->init() ; 
	        $items = $feed->get_items() ; 
	
	        foreach( $items as $key => $item){
	            print_r($item->get_title()) ; 
	        }
        //} 
    }
}
