<?php 
class Register extends Eloquent {
    protected $table = 'registers';
    protected $guarded = array() ; 
    
    static public function create(array $attr){
        $reg = new Register ; 
        $reg->fill($attr) ; 

        if($attr['program_id'] == null || $attr['program_id'] == ''){
            throw new Exception('msg') ; 
        }
        $reg->save() ; 

        return $reg; 
    }
}
