<?php 
class Tour extends Eloquent {
    protected $table = 'tours';
    protected $guarded = array() ; 
    
    static public function create(array $attr){
        $tour = new Tour ; 
        $tour->fill($attr) ; 
        $tour->save() ; 

        return $tour ; 
    }
}
