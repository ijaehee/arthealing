<?php 
class Program extends Eloquent {
    protected $table = 'programs';
    protected $guarded = array() ; 
    
    static public function create(array $attr){
        $pro = new Program ; 
        $pro->fill($attr) ; 

        if($attr['name'] == null || $attr['name'] == ''){
            throw new Exception('msg') ; 
        }
        $pro->save() ; 

        return $pro ; 
    }
}
